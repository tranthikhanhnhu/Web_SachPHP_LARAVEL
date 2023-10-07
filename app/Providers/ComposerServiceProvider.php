<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\LikedProduct;
use App\Models\ProductInCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $arrayViewFeatureCategories = [
            'client.pages.*',
        ];

        View::composer($arrayViewFeatureCategories, function ($view) {

            $categories = Category::latest()->get()->filter(function($category){
                return $category->products->count() > 0;
            })->take(32);

            if (Auth::check()) {
                $cart = ProductInCart::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
                $liked_products = LikedProduct::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            } else {
                $cart = collect([]);
                $liked_products = collect([]);
            }

            $view
            ->with('feature_categories', $categories)
            ->with('cart', $cart)
            ->with('liked_products', $liked_products);

        });
    }
}
