<?php

namespace App\Http\Controllers\Client;

use App\Filters\Products\ByBookLayouts;
use App\Filters\Products\ByCategory;
use App\Filters\Products\ByKeyword;
use App\Filters\Products\ByOrigins;
use App\Filters\Products\ByPrice;
use App\Filters\Products\ByPublishers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Origin;
use App\Models\Product;
use App\Models\ProductInOrder;
use App\Models\Publisher;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;

class ProductsController extends Controller
{
    //
    public function index() {

        $number_rent_price_days = request()->number_rent_price_days ?? 7;

        $categories = Category::where('status', 1)->get()->filter(function ($category) {
            return $category->products->count() > 0;
        });

        if (!is_null(request()->category)) {
            $categoryId = Category::firstWhere('slug', request()->category)->id;
    
            $publishers = Publisher::where('status', 1)->whereHas('products.categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();
            $origins = Origin::where('status', 1)->whereHas('products.categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->where('status', 1)->get();
        } else {
            $publishers = Publisher::where('status', 1)->get()->filter(function ($publisher) {
                return $publisher->products->count() > 0;
            });
            $origins = Origin::where('status', 1)->get()->filter(function ($origin) {
                return $origin->products->count() > 0;
            });
        }

        $sortBy = null;
        if (!is_null(request()->sort_by)) {
            switch (request()->sort_by) {
                case 1:
                    // name a-z
                    $sortBy = ['name', 'asc'];
                    break;
                case 2:
                    // name z-a
                    $sortBy = ['name', 'desc'];
                    break;
                case 3:
                    // price l-h
                    $sortBy = ['price', 'asc'];
                    break;
                case 4:
                    // price h-l
                    $sortBy = ['price', 'desc'];
                    break;
            }
        }

        $pipelines = [
            ByCategory::class,
            ByPublishers::class,
            ByOrigins::class,
            ByBookLayouts::class,
            ByPrice::class,
            ByKeyword::class,
        ];

        $pipeline = Pipeline::send(Product::query())
        ->through($pipelines)
        ->thenReturn();


        if (is_null($sortBy)) {
            $products = $pipeline->where('status', 1)->paginate(12);
        } else {
            $products = $pipeline->where('status', 1)
            ->orderBy($sortBy[0], $sortBy[1])
            ->paginate(12);
        }


        $allProductsPipelines = [
            ByCategory::class,
        ];

        $allProductsPipeline = Pipeline::send(Product::query())
        ->through($allProductsPipelines)
        ->thenReturn();

        $allProducts = $allProductsPipeline->where('status', 1)->get();

        $category = request()->category;

        foreach($allProducts as $product) {
            $rentPrices[] = $product->rentPrice->firstWhere('number_of_days', $number_rent_price_days)->price;
        }
        
        if ($rentPrices) {
            $maxPrice = max($rentPrices);
            $minPrice = min($rentPrices);
        }

        return view('client.pages.products.products', [
            'products' => $products,
            'categories' => $categories,
            'publishers' => $publishers,
            'origins' => $origins,
            'all_products' => $allProducts,
            'max_price' => $maxPrice ?? 0,
            'min_price' => $minPrice ?? 0,
        ]);
    }

    public function detail($slug) {
        
        $product = $this->getProductBySlug($slug);

        $product_categories = $product->categories()->pluck('category_id');

        $related_products = Product::whereHas('categories', function($query) use ($product_categories) {
            $query->whereIn('categories.id', $product_categories);
        })->get()->take(10);

        $bought_statuses = [
            ProductInOrder::STATUS_PICKED_UP,
            ProductInOrder::STATUS_RETURNED_BAD,
            ProductInOrder::STATUS_RETURNED_GOOD,
            ProductInOrder::STATUS_SOME_RETURNED_BAD,
            ProductInOrder::STATUS_SOME_RETURNED_GOOD,
        ];

        $ordered_statuses = array_merge($bought_statuses, [ProductInOrder::STATUS_WAIT_FOR_PICK_UP]);
    
        if(Auth::check()
        && Order::where('user_id', Auth::user()->id)
        ->whereHas('productsInOrder', function($query) use ($bought_statuses, $product) {
            $query->where('product_id', $product->id)->whereIn('status', $bought_statuses);
        })->get()->count() > 0) {
            $user_bought_this_product = true;
        } else {
            $user_bought_this_product = false;
        }
        if(Auth::check()
        && Order::where('user_id', Auth::user()->id)
        ->whereHas('productsInOrder', function($query) use ($ordered_statuses, $product) {
            $query->where('product_id', $product->id)->whereIn('status', $ordered_statuses);
        })->get()->count() > 0) {
            $user_ordered_this_product = true;
        } else {
            $user_ordered_this_product = false;
        }
    
        return view('client.pages.product_detail.product_detail', [
            'product' => $product,
            'related_products' => $related_products,
            'user_ordered_this_product' => $user_ordered_this_product,
            'user_bought_this_product' => $user_bought_this_product,
        ]);
    }

    public function getProductBySlug($slug) {

        $product = Product::firstWhere('slug', $slug);

        return $product;

    }

    public function postReview(Request $request) {
        
        $review = Review::create([
            'user_name' => $request->user_name,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'content' => $request->content,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Add review successfully'
        ]);

    }

    public function deleteReview(Review $review) {
        $review->delete();
        return redirect()->back();
    }

    public function getPrice(Product $product, $quantity, $rent_time) {
        return response()->json([
            'price' => number_format(calculatePrice($product, $rent_time, $quantity))
        ]);
    }
}
