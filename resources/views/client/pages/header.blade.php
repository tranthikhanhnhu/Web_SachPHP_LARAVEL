<nav id="top">
    <div class="header-nav">
        <div class="container">
            <div class="row">
                <div class="header-left">
                    <div class="pull-left">
                    </div>
                </div>
                <div class="content_header_right">
                    <div>
                        <p><a href="{{route('/')}}">{{ is_null(Auth::user()) ? '' : Auth::user()->username . ',' }} Welcome to
                                Store Of OurBook</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-top">
        <div class="container" id="my-dropdown-container">
            <div id="my-dropdown">
                <div class="container">
                    <div class="row" style="padding: 0 2%">
                        <h1><b>Feature Categories</b></h1>
                    </div>
                    <div class="row">
                        @foreach ($feature_categories as $category)
                            <div class="col-sm-3 col" style="text-align: left">
                                <a href="{{ route('client.products.index') }}?category={{ $category->slug }}">
                                    {{ $category->name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="header-logo">
                    <div id="logo">
                        <a href="{{ route('/') }}"><img src="{{ asset('client/image/catalog/logo.png') }}"
                                title="Your Store" alt="Your Store" class="img-responsive" /></a>
                    </div>
                </div>
                <nav class="col-sm-7 nav-container">
                    <div class="nav-inner">
                        <div id="menu" class="main-menu" style="display: block;">
                            <div id="my-menu">
                                <div id="menu-icon-container">
                                    <img src="{{ asset('client/image/ico_menu.svg') }}" alt="">
                                    <img id="dropdown-img" src="{{ asset('client/image/icon_seemore_gray.svg') }}"
                                        alt="">
                                </div>

                                <form class="search-wrapper" method="GET"
                                    action="{{ route('client.products.index') }}">
                                    <input id="search-input" name="keyword" type="text"
                                        value="{{ request()->keyword ?? '' }}"
                                        placeholder="Search for products that you're looking for...">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>

                            </div>
                        </div>
                    </div>
                </nav>
                <div class="col-sm-4 header-right">
                    <div class="header-right-container">
                        <div class="col-sm-2 header-cart">
                            <div id="cart" class="btn-group btn-block">
                                <button type="button" data-toggle="dropdown" data-loading-text="Loading..."
                                    class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i
                                        class="fa fa-shopping-cart"></i> <span
                                        id="cart-total">{{ $cart->count() }}</span></button>
                                <span class="cart"> Cart </span>
                                <div id="cart-products-container">
                                    <ul class="dropdown-menu pull-right cart-menu">
                                        @if (Auth::check())
                                            @if ($cart->count() > 0)
                                                <li>
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <a
                                                                        href="{{ route('client.products.detail', ['slug' => $cart[0]->product->slug]) }}">
                                                                        <img src="{{ asset("images/products/{$cart[0]->product->productImages->firstWhere('type', 1)->image_url}") }}"
                                                                            alt="ut labore et dolore magnam aliquam quae"
                                                                            title="ut labore et dolore magnam aliquam quae"
                                                                            class="img-thumbnail" style="height: 80px">
                                                                    </a>
                                                                </td>
                                                                <td class="text-left">
                                                                    <a
                                                                        href="https://capricathemes.com/opencart/OPC01/OPC010003/OPC1/index.php?route=product/product&amp;product_id=40">{{ $cart[0]->product->name }}</a>
                                                                </td>
                                                                <td class="text-right">123.20đ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </li>
                                                <li>
                                                    <div>
                                                        @if ($cart->count() > 1)
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-right">{{ $cart->count() - 1 }}
                                                                            more product in cart</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                        <div class="text-right button-container">
                                                            <a href="{{ route('client.cart') }}"
                                                                class="btn-primary addtocart"><strong>Go To
                                                                    Cart</strong></a>
                                                        </div>
                                                </li>
                                            @else
                                                <li>
                                                    <p class="text-center">Your shopping cart is empty!</p>
                                                </li>
                                            @endif
                                        @else
                                            <a href="{{route('login')}}" class="btn btn-primary">Login to view your cart</a>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="top-links" class="nav pull-right">
                            <ul class="list-inline">
                                <li class="dropdown myaccount"><a
                                        href="https://capricathemes.com/opencart/OPC01/OPC010003/OPC1/index.php?route=account/account"
                                    title="My Account" class="dropdown-toggle" data-toggle="dropdown"> <span
                                            class="account-toggle"></span></a>
                                    <ul class="dropdown-menu dropdown-menu-right myaccount-menu">
                                        @if (!Auth::check())
                                            <li><a href="{{ route('signup') }}">Register</a></li>
                                            <li><a href="{{ route('login') }}">Login</a></li>
                                        @endif
                                        @if (!is_null(Auth::user()) && Auth::user()->level == 1)
                                        <li><a href="{{ route('admin.index') }}">Admin page</a></li>
                                        @endif
                                        @if (Auth::check())
                                        <li><a href="{{ route('client.likedProducts') }}" id="wishlist-total"
                                                title="Wish List ({{ $liked_products->count() }})">
                                                <span class="hidden-xs">Wish List (<span
                                                        id="like-total">{{ $liked_products->count() }}</span>)</span>
                                            </a></li>
                                        <li><a href="{{route('client.orderHistory')}}">Order History</a></li>
                                        <li><a href="{{route('client.users.edit')}}">My Account</a></li>
                                        <li><a href="{{ route('logout') }}">Logout</a></li>
                                        @endif
                                    </ul>
                                </li>

                            </ul>
                        </div>
                        <div class="header-search">
                            <div class="search">
                                <div id="search" class="input-group">
                                    {{-- <div class="search_button">Search</div> --}}
                                    <div class="searchbox">
                                        <form class="search-wrapper" method="GET"
                                            action="{{ route('client.products.index') }}">
                                            <input id="search-input" name="keyword" type="text"
                                                value="{{ request()->keyword ?? '' }}"
                                                placeholder="Search for products...">
                                            <button type="submit"><i
                                                    class="fa-solid fa-magnifying-glass"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</nav>
