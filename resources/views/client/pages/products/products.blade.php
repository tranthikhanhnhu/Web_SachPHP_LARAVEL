@extends('client.layout.master')

@section('body-class')
    class="product-category-18 layout-2 left-col"
@endsection

@section('content')
    <div class="content_headercms_top"></div>
    <div class="content-top-breadcum">
        <div class="container">
            <div class="row">
                <div id="title-content">
                </div>
            </div>
        </div>
    </div>

    <div class="container category-page">
        <ul class="breadcrumb">
            {{ Breadcrumbs::render('products') }}
        </ul>
        <div class="row">
            <aside id="column-left" class="col-sm-3 hidden-xs">
                <div class="box left-category">
                    <div class="box-heading">Categories</div>
                    <div class="box-content ">
                        <ul class="box-category treeview-list treeview">
                            @php $count=0 @endphp
                            @foreach ($categories as $category)
                                <li class="@if ($count >= 10) hidden-categories @endif">
                                    <a class="@if (request()->category === $category->slug) active @endif"
                                        href="{{ route('client.products.index') }}?category={{ $category->slug }}&keyword={{ request()->keyword ?? '' }}">
                                        <span
                                            style="
                                    display: inline-block;
                                    max-width: 20ch;
                                    overflow: hidden;
                                    vertical-align: top;
                                    text-overflow: ellipsis;
                                    white-space: nowrap;
                                    ">{{ $category->name }}</span>
                                        <span>({{ $category->products->where('status', 1)->count() }})</span></a>
                                </li>
                                @php $count++ @endphp
                            @endforeach
                            <li><a class="show-more-button">
                                    <h3>Show More <i class="fa-solid fa-angle-down"></i></h3>
                                </a></li>
                        </ul>
                    </div>
                </div>
                <div class="box sidebarFilter">
                    <div class="box-heading">Filter By</div>
                    <form class="filterbox" id="filter-form" method="GET" action="{{ route('client.products.index') }}">
                        <input type="hidden" name="category" value="{{ request()->category ?? '' }}">
                        <input type="hidden" name="keyword" value="{{ request()->keyword ?? '' }}">
                        <input type="hidden" name="number_rent_price_days" id="number_rent_price_days"
                            value="{{ request()->number_rent_price_days ?? 7 }}">
                        <input type="hidden" name="sort_by" value="" id="sort_by">
                        <div class="list-group-filter">
                            <div class="filter-content">
                                <div class="list-group-item title">Publishers</div>
                                <div class="list-group-item">
                                    <div id="filter-group1">
                                        @foreach ($publishers as $publisher)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="publishers[]"
                                                        value="{{ $publisher->slug }}"
                                                        @if (request()->publishers && in_array($publisher->slug, request()->publishers)) checked @endif />
                                                    {{ $publisher->name }}
                                                    ({{ $all_products->where('publisher_id', $publisher->id)->count() }}) </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="filter-content">
                                <div class="list-group-item title">Origins</div>
                                <div class="list-group-item">
                                    <div id="filter-group2">
                                        @foreach ($origins as $origin)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="origins[]" value="{{ $origin->slug }}"
                                                        @if (request()->origins && in_array($origin->slug, request()->origins)) checked @endif />
                                                    {{ $origin->name }}
                                                    ({{ $all_products->where('origin_id', $origin->id)->count() }}) </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="filter-content">
                                <div class="list-group-item title">Price</div>
                                <div class="list-group-item">
                                    <div id="filter-group3">
                                        <label for="amount">Price range:<input type="text" id="amount" readonly
                                                style="border:0; color:#b89952; font-weight:bold;">
                                            <input type="hidden" name="amount_start" id="amount_start">
                                            <input type="hidden" name="amount_end" id="amount_end">
                                        </label>
                                        <div id="slider-range"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-content">
                                <div class="list-group-item title">Book Layout</div>
                                <div class="list-group-item">
                                    <div id="filter-group4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="book_layouts[]" value="0"
                                                    @if (request()->book_layouts && in_array(0, request()->book_layouts)) checked @endif />
                                                Paperback ({{ $products->where('book_layout', 0)->count() }}) </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="book_layouts[]" value="1"
                                                    @if (request()->book_layouts && in_array(1, request()->book_layouts)) checked @endif />
                                                Hardcover ({{ $all_products->where('book_layout', 1)->count() }}) </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" id="filter-button" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
                <script>
                    <!--
                    $('#button-filter').on('click', function() {
                        filter = [];
                        $('input[name^=\'filter\']:checked').each(function(element) {
                            filter.push(this.value);
                        });
                        location = 'index94ae.html?route=product/category&amp;path=18&amp;filter=' + filter.join(',');
                    });
                    //
                    -->
                </script>
                <script type="text/javascript">
                    <!--
                    $('.bannercarousel').owlCarousel({
                        items: 1,
                        autoPlay: 3000,
                        singleItem: true,
                        navigation: false,
                        pagination: true,
                        transitionStyle: 'fade'
                    });
                    -->
                </script>
            </aside>
            <div id="content" class="col-sm-9 category ">
                <div class="category-top">
                    <h2 class="page-title">Books</h2>
                    <div class="category_thumb">
                        <div class="col-sm-10 category_description">
                            <p>
                                Books act as a medium that bring to you the world of learning and knowledge.</p>
                        </div>
                    </div>
                </div>

                <div class="category_filter">
                    <div class="col-md-4 btn-list-grid">
                        <div class="btn-group">
                            <button type="button" id="grid-view" class="btn btn-default grid" data-toggle="tooltip"
                                title="Grid"><i class="fa fa-th-large"></i></button>
                            <button type="button" id="list-view" class="btn btn-default list" data-toggle="tooltip"
                                title="List"><i class="fa fa-th-list"></i></button>
                        </div>
                    </div>

                    <div class="pagination-right">
                        <div class="sort-by-wrapper">
                            <div class="col-md-2 text-right sort-by">
                                <label class="control-label" for="input-sort">Sort By:</label>
                            </div>
                            <div class="col-md-3 text-right sort">
                                <select id="input-sort" class="form-control" onchange="location = this.value;">
                                    <option
                                        value="0"
                                        @if((int)request()->sort_by === 0) selected @endif>Default</option>
                                    <option
                                        value="1"
                                        @if(request()->sort_by == 1) selected @endif>
                                        Name (A - Z)</option>
                                    <option
                                        value="2"
                                        @if(request()->sort_by == 2) selected @endif>
                                        Name (Z - A)</option>
                                    <option
                                        value="3"
                                        @if(request()->sort_by == 3) selected @endif>
                                        Price (Low &gt; High)</option>
                                    <option
                                        value="4"
                                        @if(request()->sort_by == 4) selected @endif>
                                        Price (High &gt; Low)</option>
                                </select>
                            </div>
                        </div>
                        <div class="show-wrapper">
                            <div class="col-md-1 text-right show">
                                <label class="control-label" for="input-sort">Show:</label>
                            </div>
                            <div class="col-md-2 text-right limit">
                                <select id="input-limit" class="form-control" onchange="location = this.value;">
                                    <option value="7" @if(request()->number_rent_price_days == 7) selected @endif>
                                        7 day price
                                    </option>
                                    <option value="1" @if(request()->number_rent_price_days == 1) selected @endif>
                                        1 day price
                                    </option>
                                    <option value="30" @if(request()->number_rent_price_days == 30) selected @endif>
                                        30 day price
                                    </option>
                                    <option value="90" @if(request()->number_rent_price_days == 90) selected @endif>
                                        90 day price
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row category-product">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="product-layout product-list col-xs-12">
                                <div class="product-block product-thumb">
                                    <div class="product-block-inner">
                                        <div class="image">
                                            <a href="{{ route('client.products.detail', ['slug' => $product->slug]) }}">
                                                <img src='{{ asset("images/products/{$product->productImages->firstWhere('type', 1)->image_url}") }}'
                                                    alt="architecto beatae vitae dicta sunt explic"
                                                    title="architecto beatae vitae dicta sunt explic"
                                                    class="img-responsive" />
                                                <img class="img-responsive hover-image"
                                                    src="{{ asset("images/products/{$product->productImages->firstWhere('type', 2)->image_url}") }}"
                                                    alt="architecto beatae vitae dicta sunt explic" />
                                            </a>
                                            <div class="button-group grid">
                                                @if (Auth::check())
                                                    <button type="button" class="wishlist" data-toggle="tooltip"
                                                        title="Add to Wish List"
                                                        data-url="{{ route('client.addToLikedProducts', ['productId' => $product->id]) }}"><i
                                                            class="fa fa-heart"></i></button>
                                                    @if($product->quantity > 0)
                                                    <button class="addtocart" type="button" data-toggle="tooltip"
                                                        title="Add to Cart"
                                                        data-url="{{ route('client.addToCart', ['productId' => $product->id]) }}"><i
                                                            class="fa fa-cart-plus"></i><span>Add to Cart</span></button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-details">
                                            <div class="caption">
                                                <h4
                                                    style="
                                                max-width: 50ch;
                                                overflow: hidden;
                                                text-overflow: ellipsis;
                                                white-space: nowrap;">
                                                    <a
                                                        href="{{ route('client.products.detail', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
                                                </h4>
                                                <p class="desc">{{$product->short_description}}</p>

                                                <p class="price">
                                                    <span
                                                        class="price-new">{{ number_format($product->rentPrice->firstWhere('number_of_days', request()->number_rent_price_days ?? 7)->price) }}đ</span>
                                                    / {{request()->number_rent_price_days ?? 7}}day
                                                    <span class="price-tax">Ex Tax: $90.00</span>
                                                </p>


                                            </div>

                                            <div class="list-right">
                                                <p class="price">
                                                    <span
                                                        class="price-new">{{ number_format($product->rentPrice->firstWhere('number_of_days', request()->number_rent_price_days ?? 7)->price) }}đ</span>
                                                    / {{request()->number_rent_price_days ?? 7}}day
                                                </p>
                                                @if(Auth::check())
                                                <div class="button-group list">
                                                    <button type="button" class="wishlist" data-toggle="tooltip"
                                                        title="Add to Wish List" onclick="wishlist.add('30');"><i
                                                            class="fa fa-heart"></i></button>
                                                    @if($product->quantity > 0)
                                                    <button class="addtocart" type="button"
                                                        data-url="{{ route('client.addToCart', ['productId' => $product->id]) }}"
                                                        title="Add to Cart"><i class="fa fa-cart-plus"></i><span>Add to
                                                            Cart</span></button>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row" style="font-size: 3rem; width: 100%; text-align: center">
                            There is no matching products
                        </div>
                    @endif
                </div>
                {{ $products->appends(request()->query())->links('client.pagination.custom') }}
            </div>
        </div>

    </div>
@endsection


@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            if ($('.hidden-categories').length === 0) {
                $('.show-more-button').hide();
            }
            $('.hidden-categories').hide();
            $('.show-more-button').click(function() {
                if ($('.hidden-categories').is(':hidden')) {
                    $('.hidden-categories').show();
                    $(this).html('<h3>Show Less <i class="fa-solid fa-angle-up"></i>')
                } else {
                    $('.hidden-categories').hide();
                    $(this).html('<h3>Show More <i class="fa-solid fa-angle-down"></i>')
                }
            });


            $('#sort_by').val($('#input-sort').val());
            $('#input-sort').on('change', function() {
                $('#sort_by').val($(this).val());
                $('#filter-form').submit();
            });
            $('#input-limit').on('change', function() {
                $('#number_rent_price_days').val($(this).val());
                $('#amount_start').val('');
                $('#amount_end').val('');
                $('#filter-form').submit();
            });

            $('.addtocart').on('click', function() {
                let url = $(this).data('url');
                $.ajax({
                    method: 'GET',
                    url: url,
                    success: function(res) {
                        reloadViewCart(res);
                        Swal.fire({
                            icon: 'success',
                            text: res.message,
                        });
                    },
                });
            });
            $('.wishlist').on('click', function() {
                let url = $(this).data('url');
                $.ajax({
                    method: 'GET',
                    url: url,
                    success: function(res) {
                        reloadViewLike(res);
                        Swal.fire({
                            icon: 'success',
                            text: res.message,
                        });
                    },
                });
            });

            function reloadViewCart(res) {
                let total = res.total;
                $('#cart-total').html(total);

                let selector = '#cart-products-container';
                let urlUpdate = window.location.href + " " + selector;
                $(selector).load(urlUpdate);
            }

            function reloadViewLike(res) {
                let total = res.total;
                $('#like-total').html(total);
            }

            $("#slider-range").slider({
                range: true,
                min: {{ $min_price }},
                max: {{ $max_price }},
                values: [{{ request()->amount_start ?? $min_price }},
                    {{ request()->amount_end ?? $max_price }}
                ],
                slide: function(event, ui) {
                    $("#amount").val(ui.values[0] + "đ" + " - " + ui.values[1] + "đ");
                    $('#amount_start').val(ui.values[0]);
                    $('#amount_end').val(ui.values[1]);
                }
            });
            $('#amount_start').val($('#slider-range').slider("values", 0));
            $('#amount_end').val($('#slider-range').slider("values", 1));
            $("#amount").val($("#slider-range").slider("values", 0) + "đ" + " - " + $("#slider-range").slider("values", 1) + "đ");
        })
    </script>
@endsection
