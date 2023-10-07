<?php

namespace App\Observers;

use App\Mail\CancelEmail;
use App\Mail\ReschedulePickUpEmail;
use App\Models\Product;
use App\Models\ProductInCart;
use App\Models\ProductInOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
        if ($product->isDirty('quantity') && ($product->getOriginal('quantity') > $product->quantity)) {
            // $waiting_items = ProductInOrder::where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)
            // ->where('product_id', $product->id)->where('expected_pick_up_date', '>=', Carbon::today()->format('Y-m-d'))
            // ->orderBy('created_at', 'asc')
            // ->get();
            if ($product->quantity == 0) {
                // foreach($waiting_items as $item) {
                //     $item->update([
                //         'status' => ProductInOrder::STATUS_CANCEL,
                //     ]);
                //     Mail::to(User::find($item->order->user_id)->email)->send(new CancelEmail($item));

                // }
                ProductInCart::where('product_id', $product->id)->delete();
            } else {
                // $waitingIds = $waiting_items->pluck('id');
                // foreach($waiting_items as $item) {
                    // $nearest = findNearestAvailableDayReschedule($item->product, $item->product_quantity > $product->quantity ? $product->quantity : $item->product_quantity, $item->rent_time, $waitingIds);
                    // unset($waitingIds[0]);
                    // if (Carbon::createFromFormat('Y-m-d', $item->expected_pick_up_date)->lt($nearest)) {
                    //     $needReschedule[$item->id] = [
                    //         'new_date' => $nearest,
                    //         'change_date' => true,
                    //         'change_quantity' => $item->product_quantity > $product->quantity ? true : false,
                    //         'new_quantity' => $product->quantity,
                    //     ];
                    // } else if ($item->product_quantity > $product->quantity) {
                    //     $needReschedule[$item->id] = [
                    //         'new_date' => $nearest,
                    //         'change_date' => false,
                    //         'change_quantity' => true,
                    //         'new_quantity' => $product->quantity,
                    //     ];
                    // }
                    // 
                // }
                ProductInCart::where('product_id', $product->id)->where('quantity', '>', $product->quantity)->update([
                    'quantity' => $product->quantity
                ]);
                // if (isset($needReschedule)) {
                //     foreach($needReschedule as $key => $detail) {
                //         $item = ProductInOrder::find($key);
                //         $item->update([
                //             'expected_pick_up_date' => $detail['new_date'],
                //             'expected_return_date' => Carbon::createFromFormat('Y-m-d', $detail['new_date'])->addDays($item->rent_time),
                //             'product_quantity' => $detail['change_quantity'] ? $item->product_quantity : $detail['new_quantity']
                //         ]);
                //         $detail['new_return_date'] = Carbon::createFromFormat('Y-m-d', $detail['new_date'])->addDays($item->rent_time)->format('Y-m-d');
                //         Mail::to(User::find($item->order->user_id)->email)->send(new ReschedulePickUpEmail($item, $detail));
    
                //     }
                // }

            }
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
