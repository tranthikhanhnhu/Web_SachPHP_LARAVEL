<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function orderDetail(Order $order) {

        $today = Carbon::today()->format('Y-m-d');

        $order_statuses = [
            'wait_for_pick_up' => ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
            'picked_up' => ProductInOrder::STATUS_PICKED_UP,
            'returned_good' => ProductInOrder::STATUS_RETURNED_GOOD,
            'cancel' => ProductInOrder::STATUS_CANCEL,
            'returned_bad' => ProductInOrder::STATUS_RETURNED_BAD,
            'some_returned_good' => ProductInOrder::STATUS_SOME_RETURNED_GOOD,
            'some_returned_bad' => ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ];

        return view('admin.pages.users.order_detail', [
            'order' => $order,
            'order_statuses' => $order_statuses,
            'today' => $today,
        ]);
    }

    public function changeStatus(ProductInOrder $productInOrder, $status, $returnedAll = false) {

        $all_products_returned = $productInOrder->returned_bad_quantity + $productInOrder->returned_good_quantity + 1 === $productInOrder->product_quantity;

        switch ($status) {

            case ProductInOrder::STATUS_PICKED_UP:
                $productInOrder->update([
                    'status' => $status,
                    'pick_up_date' => Carbon::today(),
                ]);
                break;


            case ProductInOrder::STATUS_RETURNED_BAD:
                
                $oldReturnedBadQuantity = $productInOrder->returned_bad_quantity;

                if ($returnedAll) {
                    $status = ProductInOrder::STATUS_RETURNED_BAD;
                    $returnedBadQuantity = $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity);
                    $productInOrder->update([
                        'status' => $status,
                        'return_date' => Carbon::today(),
                        'returned_bad_quantity' => $returnedBadQuantity + $oldReturnedBadQuantity,
                    ]);
                
                } else {
                    if ($all_products_returned) {
                        $status = ProductInOrder::STATUS_RETURNED_BAD;
                    } else {
                        $status = ProductInOrder::STATUS_SOME_RETURNED_BAD;
                    }
                    $returnedBadQuantity = 1;
                    $productInOrder->update([
                        'status' => $status,
                        'return_date' => Carbon::today(),
                        'returned_bad_quantity' => $returnedBadQuantity + $oldReturnedBadQuantity,
                    ]);
                }

                $product = Product::where('id', $productInOrder->product_id)->first();

                if (!Carbon::today()->gt($productInOrder->expected_return_date)) {
                    $product->update([
                        'quantity' => $product->quantity - $returnedBadQuantity,
                    ]);
                }

                $productInOrder->update([
                    'deposit_return' => $productInOrder->deposit_return - ($returnedBadQuantity * $product->price),
                ]);


                break;
                

            case ProductInOrder::STATUS_RETURNED_GOOD:
                if ($returnedAll) {
                    if ($productInOrder->status === ProductInOrder::STATUS_SOME_RETURNED_BAD) {
                        $status = ProductInOrder::STATUS_RETURNED_BAD;
                    } else {
                        $status = ProductInOrder::STATUS_RETURNED_GOOD;
                    }
                    $oldReturnedGoodQuantity = $productInOrder->returned_good_quantity;
                    $returnedGoodQuantity = $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity) + $oldReturnedGoodQuantity;
                    $productInOrder->update([
                        'status' => $status,
                        'return_date' => Carbon::today(),
                        'returned_good_quantity' => $returnedGoodQuantity,
                    ]);

                } else {

                    if ($all_products_returned) {
                        if ($productInOrder->status === ProductInOrder::STATUS_SOME_RETURNED_BAD) {
                            $status = ProductInOrder::STATUS_RETURNED_BAD;
                        } else {
                            $status = ProductInOrder::STATUS_RETURNED_GOOD;
                        }
                    } else {
                        if ($productInOrder->status === ProductInOrder::STATUS_SOME_RETURNED_BAD) {
                            $status = ProductInOrder::STATUS_SOME_RETURNED_BAD;
                        } else {
                            $status = ProductInOrder::STATUS_SOME_RETURNED_GOOD;
                        }
                    }
                    $returnedGoodQuantity = $productInOrder->returned_good_quantity + 1;
                    $productInOrder->update([
                        'status' => $status,
                        'return_date' => Carbon::today(),
                        'returned_good_quantity' => $returnedGoodQuantity,
                    ]);
                }
                if (Carbon::today()->gt($productInOrder->expected_return_date)) {
                    $product = Product::firstWhere('id', $productInOrder->product_id);
                    $oldProductQuantity = $product->quantity;
                    $productQuantity = $oldProductQuantity + $returnedGoodQuantity;
                    $product->update([
                        'quantity' => $productQuantity,
                    ]);
                }
                break;


            case ProductInOrder::STATUS_CANCEL:
                if ($productInOrder->status === ProductInOrder::STATUS_WAIT_FOR_PICK_UP) {
                    $productInOrder->update([
                        'status' => ProductInOrder::STATUS_CANCEL,
                    ]);
                }
                break;
        }

        if ($productInOrder) {
            return back()->with('message', '<div class="alert alert-success alert-dismissible">Item changed status successfully</div>');
        } else {
            return back()->with('message', '<div class="alert alert-danger alert-dismissible">Item changed status failed</div>');
        }

    }
}
