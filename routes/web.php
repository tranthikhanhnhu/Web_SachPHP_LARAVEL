<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Client\ProductsController as ClientProductsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\OriginsController;
use App\Http\Controllers\Admin\PublishersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\CartsController;
use App\Http\Controllers\Client\HomePageController;
use App\Http\Controllers\Client\InformationController;
use App\Http\Controllers\Client\LikedProductsController;
use App\Http\Controllers\Client\OrdersController as ClientOrdersController;
use App\Http\Controllers\Client\UsersController as ClientUsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomePageController::class, 'index'])->name('/');
Route::get('aboutUs', [InformationController::class, 'aboutUs'])->name('aboutUs');


Route::prefix('admin')->middleware(['checkLogin', 'isAdmin', 'checkStatus'])->name('admin.')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/index', [AdminController::class, 'index']);
    

    Route::resource('users', UsersController::class);
    Route::prefix('users')->controller(UsersController::class)->name('users.')->group(function() {
        Route::post('/changeStatus/{user}', 'changeStatus')->name('changeStatus');
    });

    Route::prefix('orders')->controller(OrdersController::class)->name('orders.')->group(function() {
        Route::get('/order_detail/{order}', 'orderDetail')->name('order_detail');
        Route::get('/changeStatus/{productInOrder}/{status}/{returnedAll?}', 'changeStatus')->name('changeStatus');
    });
    
    Route::resource('products', ProductsController::class);
    Route::prefix('categories')->controller(CategoriesController::class)->name('categories.')->group(function() {
        Route::post('/changeStatus/{category}', 'changeStatus')->name('changeStatus');
        Route::post('/getSlug', 'getSlug')->name('getSlug');
    });

    Route::resource('categories', CategoriesController::class);
    Route::prefix('products')->controller(ProductsController::class)->name('products.')->group(function() {
        Route::post('/changeStatus/{product}', 'changeStatus')->name('changeStatus');
        Route::post('/getSlug', 'getSlug')->name('getSlug');
        Route::post('/getRentPrices', 'getRentPrices')->name('getRentPrices');
        Route::get('/deleteReview/{review}', 'deleteReview')->name('deleteReview');
    });

    Route::resource('publishers', PublishersController::class);
    Route::prefix('publishers')->controller(PublishersController::class)->name('publishers.')->group(function() {
        Route::post('/changeStatus/{publisher}', 'changeStatus')->name('changeStatus');
        Route::post('/getSlug', 'getSlug')->name('getSlug');
    });

    Route::resource('origins', OriginsController::class);
    Route::prefix('origins')->controller(OriginsController::class)->name('origins.')->group(function() {
        Route::post('/changeStatus/{origin}', 'changeStatus')->name('changeStatus');
        Route::post('/getSlug', 'getSlug')->name('getSlug');
    });
});

Route::middleware('checkStatus')->name('client.')->group(function() {
    Route::get('/index', [HomePageController::class, 'index'])->name('index');
    Route::prefix('/products')->controller(ClientProductsController::class)->name('products.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/index', 'index');
        Route::get('/detail/{slug}', 'detail')->name('detail');
        Route::post('/postReview', 'postReview')->name('postReview');
        Route::get('/deleteReview/{review}', 'deleteReview')->name('deleteReview');
        Route::get('/getPrice/{product}/{quantity?}/{rent_time?}', 'getPrice')->name('getPrice');
    });
    Route::prefix('account')->middleware('checkLogin')->group(function() {
        Route::controller(CartsController::class)->group(function() {
            Route::get('/cart', 'cart')->name('cart');
            Route::post('/setPickUpDate', 'setPickUpDate')->name('setPickUpDate');
            Route::get('/addToCart/{productId}/{qty?}/{rent_time?}', 'addToCart')->name('addToCart');
            Route::get('/removeFromCart/{productId}', 'removeFromCart')->name('removeFromCart');
            Route::get('/updateCart/{productId}/{qty?}/{rent_time?}', 'updateCart')->name('updateCart');
            Route::get('/removeCart', 'removeCart')->name('removeCart');
        });
        Route::controller(LikedProductsController::class)->group(function() {
            Route::get('/likedProducts', 'likedProducts')->name('likedProducts');
            Route::get('/addToLikedProducts/{productId}/{qty?}', 'addToLikedProducts')->name('addToLikedProducts');
            Route::get('/removeFromLikedProducts/{productId}', 'removeFromLikedProducts')->name('removeFromLikedProducts');
        });
        Route::controller(ClientOrdersController::class)->group(function() {
            Route::get('/checkout', 'checkout')->name('checkout');
            Route::get('/placeOrder', 'placeOrder')->name('placeOrder');
            Route::get('/cancelOrder/{orderId}', 'cancelOrder')->name('cancelOrder');
            Route::get('/cancelOrderItem/{productInOrderId}', 'cancelOrderItem')->name('cancelOrderItem');
            Route::get('/orderHistory', 'orderHistory')->name('orderHistory');
            Route::post('/postExtendRentTime', 'postExtendRentTime')->name('postExtendRentTime');
            Route::get('/getItemTotal/{productInOrder}/{rent_time?}', 'getItemTotal')->name('getItemTotal');
            Route::middleware('checkOrderOwner')->group(function() {
                Route::get('/orderDetail/{order}', 'orderDetail')->name('orderDetail');
            });
            Route::get('/orderDetail/extendRentTime/{productInOrderId}', 'extendRentTime')->name('extendRentTime');
        });
        Route::controller(ClientUsersController::class)->name('users.')->group(function() {
            Route::get('', 'edit')->name('edit');
            Route::post('/update', 'update')->name('update');
        });
    });
});

Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/postLOgin', 'postLOgin')->name('postLogin');
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/storeUser', 'storeUser')->name('storeUser');
    Route::get('/logout', 'logout')->name('logout');
});