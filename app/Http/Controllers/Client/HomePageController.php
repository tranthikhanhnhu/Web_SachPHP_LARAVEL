<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomePageController extends Controller
{
    //
    public function index()
    {
        //
        $feature_products = Product::paginate(8);

        return view('client.pages.index.index', [
            'feature_products' => $feature_products,
        ]);
    }
}
