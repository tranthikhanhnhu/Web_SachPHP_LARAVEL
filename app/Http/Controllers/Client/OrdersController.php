<?php

namespace App\Http\Controllers\Client;

use App\Filters\Orders\ByActive;
use App\Http\Controllers\Controller;
use App\Mail\ExtendRentalEmail;
use App\Mail\OrderEmail;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInCart;
use App\Models\ProductInOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Pipeline;

class OrdersController extends Controller
{
    //
    public function checkout() {
        
        $today = Carbon::now()->format('Y-m-d');

        return view('client.pages.checkout.checkout', [
            'today' => $today,
        ]);
    }

    public function placeOrder() {

        $cart = ProductInCart::where('user_id', Auth::user()->id)->get();

        foreach ($cart as $item) {
            if (checkWillPickUp($item->product, $item->pick_up_date, $item->rent_time, $item->quantity)) {
                return redirect()->back()->with('message', 'Order Failed');
            }
        }

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $total = 0;

        foreach($cart as $item) {
            $productPrice = calculatePrice($item->product, $item->rent_time, $item->quantity);
            $total += $productPrice;
            $deposit = $item->product->price * $item->quantity;
            $deposit_return = $deposit - $productPrice;
            ProductInOrder::create([
                'created_at' => Carbon::now(),
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'product_name' => $item->product->name,
                'product_price' => $productPrice,
                'product_quantity' => $item->quantity,
                'expected_pick_up_date' => $item->pick_up_date,
                'expected_return_date' => Carbon::parse($item->pick_up_date)->addDays($item->rent_time),
                'deposit' => $deposit,
                'deposit_return' => $deposit_return,
                'rent_time' => $item->rent_time,
                'status' => ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
            ]);
        }

        $order->update([
            'total' => $total,
        ]);


        Mail::to(Auth::user()->email)->send(new OrderEmail($order));

        ProductInCart::where('user_id', Auth::user()->id)->delete();

        return redirect()->route('/')->with('message', 'Order successfully');
    }

    public function cancelOrder($orderId) {
        ProductInOrder::where('order_id', $orderId)->update([
            'status' => ProductInOrder::STATUS_CANCEL,
        ]);

        return response()->json([
            'message' => 'Order cancelled',
        ]);
    }

    public function cancelOrderItem($productInOrderId) {
        ProductInOrder::find($productInOrderId)->update([
            'status' => ProductInOrder::STATUS_CANCEL
        ]);

        return response()->json([
            'message' => 'Order cancelled',
        ]);
    }

    public function orderHistory() {

        $pipelines = [
            ByActive::class,
        ];

        $pipeline = Pipeline::send(Order::query())
        ->through($pipelines)
        ->thenReturn();


        $orders = $pipeline->where('user_id', Auth::user()->id)->paginate(10);

        return view('client.pages.order.order_history', [
            'orders' => $orders,
        ]);
    }

    public function orderDetail(Order $order) {

        $items = $order->productsInOrder;

        $productInOrderStatuses = ProductInOrder::STATUS;

        $activeStatuses = [
            ProductInOrder::STATUS_PICKED_UP,
            ProductInOrder::STATUS_SOME_RETURNED_GOOD,
            ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ];

        return view('client.pages.order.order_detail', [
            'items' => $items,
            'productInOrderStatuses' => $productInOrderStatuses,
            'activeStatuses' => $activeStatuses,
            'order' => $order,
        ]);
    }

    public function extendRentTime($productInOrderId) {

        $item = ProductInOrder::find($productInOrderId);

        $activeStatuses = [
            ProductInOrder::STATUS_PICKED_UP,
            ProductInOrder::STATUS_SOME_RETURNED_GOOD,
            ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ];

        if (!in_array($item->status, $activeStatuses)) {
            return redirect()->back();
        }

        return view('client.pages.extend_rent_time.extend_rent_time', [
            'item' => $item,
        ]);
    }

    public function postExtendRentTime(Request $request) {
        $productInOrder = ProductInOrder::find($request->productInOrderId);


        if (checkWillPickUpExtend($productInOrder->product, $productInOrder->expected_return_date, $productInOrder->rent_time, $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity), $productInOrder)) {
            return redirect()->back()->with('message', 'Extend Rent Time Failed');
        }

        $product = Product::find($productInOrder->product_id);
        $add_price = calculatePrice($product, $request->extend_time, $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity));
        $new_price = $productInOrder->product_price + $add_price;
        Log::info($new_price);
        Log::info($add_price);
        $new_return_date = Carbon::createFromFormat('Y-m-d', $productInOrder->expected_return_date)->addDays($request->extend_time);
        if (Carbon::today()->gt($productInOrder->expected_return_date)) {
            $new_product_quantity = $product->quantity + $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity);
        }
        $productInOrder->update([
            'product_price' => $new_price,
            'expected_return_date' => $new_return_date,
            'deposit_return' => $productInOrder->deposit_return - $add_price,
            'rent_time' => $productInOrder->rent_time + $request->extend_time
        ]);
        $order = $productInOrder->order;
        $new_total = $order->total + $add_price;
        $order->update([
            'total' => $new_total,
        ]);

        Mail::to(Auth::user()->email)->send(new ExtendRentalEmail($productInOrder));

        return redirect()->route('/')->with('message', 'Rental extended successfully');
    }

    public function getItemTotal(ProductInOrder $productInOrder, $rent_time) {

        $product = $productInOrder->product;

        $quantity = $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity);

        return response()->json([
            'total' => number_format(calculatePrice($product, $rent_time, $quantity))
        ]);
    }
}
