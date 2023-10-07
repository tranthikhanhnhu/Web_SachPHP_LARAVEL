@extends('client.layout.master')

@section('body-class')
    class="account-login layout-2 left-col"
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

    <div class="container">
        <ul class="breadcrumb">
            {{Breadcrumbs::render('cart')}}
        </ul>
        <div class="row">
            @include('client.pages.account_sidebar.account_sidebar')
            <div id="content" class="col-sm-9">
                <div class="panel-collapse collapse in" id="collapse-checkout-option" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Cart</h2>
                            </div>
                        </div>
                    </div>
                </div>
                @if($cart->count() > 0)
                    <form action=""
                        method="post" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-bordered shopping-cart">
                                <thead>
                                    <tr>
                                        <td class="text-center">Image</td>
                                        <td class="text-left">Product Name</td>
                                        <td class="text-left">Quantity</td>
                                        <td class="text-left">Rent Time(days)</td>
                                        <td class="text-right">Unit Price</td>
                                        <td class="text-right">Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total=0 @endphp
                                    @foreach($cart as $item)
                                    <tr id="cartItem{{$item->id}}">
                                        <td class="text-center"> <a
                                                href="{{route('client.products.detail', ['slug' => $item->product->slug])}}"><img
                                                src="{{asset("images/products/{$item->product->productImages->firstWhere('type', 1)->image_url}")}}"
                                                alt="ut labore et dolore magnam aliquam quae"
                                                title="ut labore et dolore magnam aliquam quae" class="img-thumbnail"
                                                style="height: 80px"></a>
                                        </td>
                                        <td class="text-left">
                                            <a href="{{route('client.products.detail', ['slug' => $item->product->slug])}}">{{$item->product->name}}</a>
                                        </td>
                                        <td class="text-left">
                                            <div class="input-group btn-block" style="max-width: 200px;">
                                                <input type="number" value="{{$item->quantity}}"
                                                    class="form-control quantity-input" id="quantity-input{{$item->id}}"
                                                    data-url="{{route('client.updateCart', ['productId' => $item->product->id])}}"
                                                    data-id="{{$item->id}}"
                                                    min="1"
                                                    max="{{$item->product->quantity}}"
                                                    min="1">
                                                <span class="input-group-btn">
                                                    <button type="button" title=""
                                                        class="btn btn-danger remove-from-cart-button"
                                                        data-url="{{route('client.removeFromCart', ['productId' => $item->product->id])}}"
                                                        data-id="{{$item->id}}"
                                                        ><i
                                                        class="fa fa-times-circle"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="input-group btn-block" style="width: 100px;">
                                                <select name="rent_time" id="rent-time-input{{$item->id}}"
                                                class="form-control rent-time-input"
                                                data-url="{{route('client.updateCart', ['productId' => $item->product->id])}}"
                                                data-id="{{$item->id}}">
                                                    <option value="7" @if($item->rent_time === 7) selected @endif>7</option>
                                                    <option value="1" @if($item->rent_time === 1) selected @endif>1</option>
                                                    <option value="3" @if($item->rent_time === 3) selected @endif>3</option>
                                                    <option value="30" @if($item->rent_time === 30) selected @endif>30</option>
                                                    <option value="90" @if($item->rent_time === 90) selected @endif>90</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div>{{number_format($item->product->rentPrice->firstWhere('number_of_days', 1)->price)}}đ/1day</div>
                                            <div>{{number_format($item->product->rentPrice->firstWhere('number_of_days', 7)->price)}}đ/7day</div>
                                            <div>{{number_format($item->product->rentPrice->firstWhere('number_of_days', 30)->price)}}đ/30day</div>
                                            <div>{{number_format($item->product->rentPrice->firstWhere('number_of_days', 90)->price)}}đ/90day</div>
                                        </td>
                                        <td class="text-right" id="total-field{{$item->id}}">{{number_format(calculatePrice($item->product, $item->rent_time, $item->quantity))}}đ</td>
                                    </tr>
                                    @php
                                        $total+=calculatePrice($item->product, $item->rent_time, $item->quantity);
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <br>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><strong>Total:</strong></td>
                                        <td class="text-right" id="total-field">{{number_format($total)}}đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="buttons clearfix">
                        <div class="pull-left"><a
                                href="{{route('/')}}"
                                class="btn btn-primary">Continue Shopping</a></div>
                        <div class="pull-right"><a
                                href="{{route('client.checkout')}}"
                                class="btn btn-primary">Checkout</a></div>
                    </div>
                @else
                    <div class="row" style="font-size: 3rem; width: 100%; text-align: center">
                        There is nothing in cart
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.remove-from-cart-button').click(function() {
            let url = $(this).data('url');
            let id = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: url,
                success: function(res) {
                    $('#cartItem'+id).empty();
                    reloadViewCart(res);

                    Swal.fire ({
                        icon: 'success',
                        text: res.message,
                    });
                },
            }); 
        });
        function reloadViewCart(res) {
            let total = res.total;
            $('#cart-total').html(total);
            console.log(res.totalPrice + 'đ');
            $('#total-field').html(res.totalPrice + 'đ');

            let selector = '#cart-products-container';
            let urlUpdate = window.location.href + " " + selector;
            $(selector).load(urlUpdate);
        }

        $('.quantity-input').on('change input', function() {
            if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
                $(this).val($(this).attr('max'));
            } else if (parseInt($(this).val()) < parseInt($(this).attr('min'))) {
                $(this).val($(this).attr('min'));
            }
            let url = $(this).data('url');
            let id = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: url + '/' + $(this).val() + '/' + $('#rent-time-input' + id).val(),
                success: function(res){
                    reloadViewCart(res);
                    $('#total-field'+id).html(res.totalItemPrice + 'đ');
                },
            });
        });
        $('.rent-time-input').on('change input', function() {
            let url = $(this).data('url');
            let id = $(this).data('id');
            $.ajax({
                method: 'GET',
                url: url + '/' + $('#quantity-input' + id).val() + '/' + $(this).val(),
                success: function(res){
                    reloadViewCart(res);
                    $('#total-field'+id).html(res.totalItemPrice + 'đ');
                },
            });
        });
    });
</script>
@endsection