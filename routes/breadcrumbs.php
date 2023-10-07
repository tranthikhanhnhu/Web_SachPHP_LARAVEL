<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\Origin;
use App\Models\Product;
use App\Models\ProductInOrder;
use App\Models\Publisher;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;



Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('/'));
});
Breadcrumbs::for('aboutUs', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('aboutUs', route('aboutUs'));
});


Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('products', route('client.products.index'));
});
Breadcrumbs::for('productDetail', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('products');
    $trail->push($product->name, route('client.products.detail', ['slug' => $product->slug]));
});



Breadcrumbs::for('account', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('account', route('client.users.edit'));
});
Breadcrumbs::for('checkout', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push('checkout', route('client.checkout'));
});
Breadcrumbs::for('likedProducts', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push('wish list', route('client.likedProducts'));
});
Breadcrumbs::for('orderHistory', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push('order history', route('client.orderHistory'));
});
Breadcrumbs::for('orderDetail', function (BreadcrumbTrail $trail, Order $order) {
    $trail->parent('orderHistory');
    $trail->push('order '.$order->id, route('client.orderDetail', ['order' => $order->id]));
});
Breadcrumbs::for('extendRentTime', function (BreadcrumbTrail $trail, ProductInOrder $item, Order $order) {
    $trail->parent('orderDetail', $order);
    $trail->push($item->product_name, route('client.extendRentTime', ['productInOrderId' => $item->id]));
});
Breadcrumbs::for('cart', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push('cart ', route('client.cart'));
});
Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push('login', route('login'));
});
Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('account');
    $trail->push('register', route('signup'));
});






Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->push('Admin', route('admin.index'));
});

Breadcrumbs::for('admin.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Users', route('admin.users.index'));
});
Breadcrumbs::for('admin.users.detail', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('admin.users');
    $trail->push($user->username, route('admin.users.show', ['user' => $user->id]));
});
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('admin.users.detail', $user);
    $trail->push('Edit', route('admin.users.edit', ['user' => $user->id]));
});
Breadcrumbs::for('admin.users.order', function (BreadcrumbTrail $trail, Order $order, User $user) {
    $trail->parent('admin.users.detail', $user);
    $trail->push('Order '.$order->id, route('admin.orders.order_detail', ['order' => $order->id]));
});
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users');
    $trail->push('Create', route('admin.users.create'));
});



Breadcrumbs::for('admin.categories', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Categories', route('admin.categories.index'));
});
Breadcrumbs::for('admin.categories.detail', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('admin.categories');
    $trail->push($category->name, route('admin.categories.show', ['category' => $category->id]));
});
Breadcrumbs::for('admin.categories.edit', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('admin.categories.detail', $category);
    $trail->push('Edit');
});
Breadcrumbs::for('admin.categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.categories');
    $trail->push('Create', route('admin.categories.create'));
});



Breadcrumbs::for('admin.products', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Products', route('admin.products.index'));
});
Breadcrumbs::for('admin.products.detail', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('admin.products');
    $trail->push($product->name, route('admin.products.show', ['product' => $product->id]));
});
Breadcrumbs::for('admin.products.edit', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('admin.products.detail', $product);
    $trail->push('Edit');
});
Breadcrumbs::for('admin.products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.products');
    $trail->push('Create', route('admin.products.create'));
});



Breadcrumbs::for('admin.origins', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Origins', route('admin.origins.index'));
});
Breadcrumbs::for('admin.origins.detail', function (BreadcrumbTrail $trail, Origin $origin) {
    $trail->parent('admin.origins');
    $trail->push($origin->name, route('admin.origins.show', ['origin' => $origin->id]));
});
Breadcrumbs::for('admin.origins.edit', function (BreadcrumbTrail $trail, Origin $origin) {
    $trail->parent('admin.origins.detail', $origin);
    $trail->push('Edit');
});
Breadcrumbs::for('admin.origins.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.origins');
    $trail->push('Create', route('admin.origins.create'));
});



Breadcrumbs::for('admin.publishers', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Publishers', route('admin.publishers.index'));
});
Breadcrumbs::for('admin.publishers.detail', function (BreadcrumbTrail $trail, Publisher $publisher) {
    $trail->parent('admin.publishers');
    $trail->push($publisher->name, route('admin.publishers.show', ['publisher' => $publisher->id]));
});
Breadcrumbs::for('admin.publishers.edit', function (BreadcrumbTrail $trail, Publisher $publisher) {
    $trail->parent('admin.publishers.detail', $publisher);
    $trail->push('Edit');
});
Breadcrumbs::for('admin.publishers.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.publishers');
    $trail->push('Create', route('admin.publishers.create'));
});

?>