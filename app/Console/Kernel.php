<?php

namespace App\Console;

use App\Mail\CancelEmail;
use App\Mail\ReschedulePickUpEmail;
use App\Models\Product;
use App\Models\ProductInOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            // cancel pick up late
            $items = ProductInOrder::where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)->get();
            foreach ($items as $item) {
                if ((Carbon::today()->gt($item->expected_pick_up_date) && Carbon::today()->diffInDays($item->expected_pick_up_date) >= 3)
                    || Carbon::today()->gte($item->expected_return_date)
                ) {
                    $item->update([
                        'status' => ProductInOrder::STATUS_CANCEL,
                    ]);
                }
            }
    
            // count not returned yesterday as lost
            $active_statuses = [
                ProductInOrder::STATUS_PICKED_UP,
                ProductInOrder::STATUS_SOME_RETURNED_BAD,
                ProductInOrder::STATUS_SOME_RETURNED_GOOD,
            ];
            $products_need_update = [];
            $not_available_items = ProductInOrder::whereIn('status', $active_statuses)->get();
            foreach ($not_available_items as $item) {
                if (Carbon::today()->gt($item->expected_return_date)) {
                    $did_not_return_quantity = $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);
    
                    if ($item->lated !== 1) {
                        if (array_key_exists($item->product_id, $products_need_update)) {
                            $products_need_update[$item->product_id] += $did_not_return_quantity;
                        } else {
                            $products_need_update[$item->product_id] = $did_not_return_quantity;
                        }
                    }
    
                    $new_deposit_return = $item->deposit_return - ($item->product->rentPrice->firstWhere('number_of_days', 1)->price * $did_not_return_quantity);
                    $new_deposit_return = $new_deposit_return >= 0 ? $new_deposit_return : 0;
                    $item->update([
                        'deposit_return' => $new_deposit_return,
                        'lated' => 1,
                    ]);
                }
            }
    
            foreach ($products_need_update as $id => $quantity) {
                $product = Product::find($id);
                $new_quantity = $product->quantity - $quantity;
                $product->update([
                    'quantity' => $new_quantity,
                ]);
            }
    
    
            // check availability of today orders
            $today_products = Product::whereHas('productInOrders', function ($query) {
                $query->where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)->where('expected_pick_up_date', Carbon::today()->format('Y-m-d'));
            })->get();
            foreach ($today_products as $product) {
                $waiting_items = ProductInOrder::where('product_id', $product->id)->where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)->orderBy('created_at', 'asc')->get();
                if ($product->quantity == 0) {
                    foreach ($waiting_items as $item) {
                        if ($item->expected_pick_up_date === Carbon::today()->format('Y-m-d')) {
                            $item->update([
                                'status' => ProductInOrder::STATUS_CANCEL,
                            ]);
                            Mail::to(User::find($item->order->user_id)->email)->send(new CancelEmail($item));
                        }
                    }
                } else {
                    $waitingIds = $waiting_items->pluck('id');
                    foreach ($waiting_items as $item) {
                        $nearest = findNearestAvailableDayReschedule($item->product, $item->product_quantity > $product->quantity ? $product->quantity : $item->product_quantity, $item->rent_time, $waitingIds);
                        unset($waitingIds[0]);
                        if ($item->expected_pick_up_date === Carbon::today()->format('Y-m-d')) {
                            if (Carbon::createFromFormat('Y-m-d', $item->expected_pick_up_date)->lt($nearest)) {
                                $detail = [
                                    'new_date' => $nearest,
                                    'change_date' => true,
                                    'change_quantity' => false,
                                    'new_quantity' => $product->quantity,
                                    'new_price' => $item->product_price,
                                ];
                                Log::info($item->product_price);
                            } else if ($item->product_quantity > $product->quantity) {
                                $detail = [
                                    'new_date' => $nearest,
                                    'change_date' => false,
                                    'change_quantity' => true,
                                    'new_quantity' => $product->quantity,
                                    'new_price' => $item->product_price / $item->product_quantity * $product->quantity,
                                ];
                                Log::info($item->product_price / $item->product_quantity * $product->quantity);
                            } else {
                                $detail = null;
                            }
                            
                            if (!is_null($detail)) {
                                $item->update([
                                    'expected_pick_up_date' => $detail['new_date'],
                                    'expected_return_date' => Carbon::createFromFormat('Y-m-d', $detail['new_date'])->addDays($item->rent_time),
                                    'product_quantity' => ($detail['change_quantity'] && !$detail['change_date']) ? $detail['new_quantity'] : $item->product_quantity,
                                    'product_price' => $detail['new_price'],
                                    'deposit_return' => $item->deposit - $detail['new_price'],
                                ]);
                                $detail['new_return_date'] = Carbon::createFromFormat('Y-m-d', $detail['new_date'])->addDays($item->rent_time)->format('Y-m-d');
                                Mail::to(User::find($item->order->user_id)->email)->send(new ReschedulePickUpEmail($item, $detail));
                            }
                        }
                    }
                }
            }
        })->daily();
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
