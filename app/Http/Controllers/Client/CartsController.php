<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductInCart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response as HttpResponse;

class CartsController extends Controller
{
    //
    public function cart() {
        return view('client.pages.cart.cart');
    }


    public function addToCart($productId, $qty = 1, $rent_time = 7)
    {

        $product = Product::find($productId);
        
        $check_is_in_cart = ProductInCart::where('product_id', $productId)->where('user_id', Auth::user()->id)->first();

        if ($product && $product->quantity > 0) {
            
            if (!$check_is_in_cart) {
                $product_in_cart = ProductInCart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                    'quantity' => $qty > $product->quantity ? $product->quantity : $qty,
                    'rent_time' => $rent_time,
                ]);
            } else {
                $quantity = ($check_is_in_cart->quantity + $qty) > $product->quantity ? $product->quantity : ($check_is_in_cart->quantity + $qty);
                $product_in_cart = $check_is_in_cart->update([
                    'quantity' => $quantity,
                    'rent_time' => $rent_time,
                ]);
            }
            
            $total = ProductInCart::where('user_id', Auth::user()->id)->get()->count();

            $totalPrice = number_format($this->calculateTotal());

            return response()->json([
                'message' => 'Add product to cart successfully',
                'total' => $total,
                'totalPrice' => $totalPrice,
            ]);
        } else {
            return response()->json(['message' => 'Add product failed'], HttpResponse::HTTP_NOT_FOUND);
        }
    }

    public function removeFromCart($productId)
    {
        ProductInCart::where('product_id', $productId)
        ->where('user_id', Auth::user()->id)->delete();

        $total = ProductInCart::where('user_id', Auth::user()->id)->get()->count();

        $totalPrice = number_format($this->calculateTotal());

        return response()->json([
            'message' => 'Remove product from cart successfully',
            'total' => $total,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function updateCart($productId, $qty, $rent_time)
    {

        $productInCart = 
        ProductInCart::where('product_id', $productId)
        ->firstWhere('user_id', Auth::user()->id);
        
        $productInCart->update([
            'quantity' => $qty,
            'rent_time' => $rent_time,
        ]);

        $cart = ProductInCart::where('user_id', Auth::user()->id);

        $total = $cart->count();
        $totalPrice = number_format($this->calculateTotal());
        $totalItemPrice = number_format($this->calculateItemTotal($productInCart));

        return response()->json([
            'message' => 'Update cart successfully',
            'total' => $total,
            'totalPrice' => $totalPrice,
            'totalItemPrice' => $totalItemPrice,
        ]);
    }

    public function setPickUpDate(Request $request) {
        $check = ProductInCart::where('product_id', $request->product_id)->update([
            'pick_up_date' => Carbon::createFromFormat('Y-m-d', $request->date),
        ]);

        $msg = $check ? 'Set date successfully' : 'Set date failed';

        return response()->json([
            'message' => $msg,
        ]);
    }

    public function calculateItemTotal(ProductInCart $productInCart) {
        return calculatePrice($productInCart->product, $productInCart->rent_time, $productInCart->quantity);
    }

    public function calculateTotal() {

        $total = 0;
        $cart = ProductInCart::where('user_id', Auth::user()->id)->get();

        foreach ($cart as $item) {
            $total += calculatePrice($item->product, $item->rent_time, $item->quantity);
        }

        return $total;

    }

    public function removeCart()
    {
        ProductInCart::where('user_id', Auth::user()->id)->delete();
        return response()->json(['message' => 'Remove all cart item successfully']);
    }
}
