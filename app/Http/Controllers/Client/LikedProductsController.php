<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LikedProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response as HttpResponse;

class LikedProductsController extends Controller
{
    //
    public function likedProducts() {
        return view('client.pages.liked_products.liked_products');
    }


    public function addToLikedProducts($productId, $qty = 1)
    {

        $product = Product::find($productId);
        $check_is_in_liked_products = LikedProduct::where('product_id', $productId)->where('user_id', Auth::user()->id)->first();

        if ($product) {
            
            if (!$check_is_in_liked_products) {
                $product_in_liked_products = LikedProduct::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                ]);
            }

            $total = LikedProduct::where('user_id', Auth::user()->id)->get()->count();

            return response()->json([
                'message' => 'Add product to liked Products successfully',
                'total' => $total,
            ]);
        } else {
            return response()->json(['message' => 'Add product failed'], HttpResponse::HTTP_NOT_FOUND);
        }
    }

    public function removeFromLikedProducts($productId)
    {

        LikedProduct::where('product_id', $productId)
        ->where('user_id', Auth::user()->id)->delete();

        $total = LikedProduct::where('user_id', Auth::user()->id)->get()->count();

        return response()->json([
            'message' => 'Remove product from liked products successfully',
            'total' => $total,
        ]);
    }


    public function removeLikedProducts()
    {
        session()->put('likedProducts', []);
        return response()->json(['message' => 'Remove all liked Products item successfully']);
    }
}
