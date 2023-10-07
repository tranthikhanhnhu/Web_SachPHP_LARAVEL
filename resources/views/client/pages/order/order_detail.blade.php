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

    <!-- ======= Quick view JS ========= -->
    <script>
        function quickbox() {
            if ($(window).width() > 767) {
                $('.quickview-button').magnificPopup({
                    type: 'iframe',
                    delegate: 'a',
                    preloader: true,
                    tLoading: 'Loading image #%curr%...',
                });
            }
        }
        jQuery(document).ready(function() {
            quickbox();
        });
        jQuery(window).resize(function() {
            quickbox();
        });
    </script>
    <div class="container">
        <ul class="breadcrumb">
            {{Breadcrumbs::render('orderDetail', $order)}}
        </ul>
        <div class="row">
            @include('client.pages.account_sidebar.account_sidebar')
            <div id="content" class="col-sm-9">
                <div class="panel-collapse collapse in" id="collapse-checkout-option" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Order Detail</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="table-container">
                    <div class="table-responsive">
                        <table class="table table-bordered shopping-cart">
                            <thead>
                                <tr>
                                    <td class="text-left">Image</td>
                                    <td class="text-left">Name</td>
                                    <td class="text-left">Rent Time</td>
                                    <td class="text-left">Quantity</td>
                                    <td class="text-left">Pick Up Date</td>
                                    <td class="text-left">Return Date</td>
                                    <td class="text-left">Price</td>
                                    <td class="text-left">Deposit</td>
                                    <td class="text-left">Status</td>
                                    <td class="text-left">Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="text-left">
                                            <img 
                                            style="height: 80px"
                                            src="{{ asset("images/products/{$item->product->productImages->firstWhere('type', 1)->image_url}") }}" 
                                            alt="No Image">
                                        </td>
                                        <td class="text-left">{{ $item->product_name }}</td>
                                        <td class="text-left">{{ $item->rent_time }} day(s)</td>
                                        <td class="text-left">{{ $item->product_quantity }}</td>
                                        <td class="text-left">{{ $item->pick_up_date ?? $item->expected_pick_up_date }}</td>
                                        <td class="text-left">{{ $item->return_date ?? $item->expected_return_date }}</td>
                                        <td class="text-left">{{ number_format($item->product_price) }}đ</td>
                                        <td class="text-left">{{ number_format($item->deposit) }}đ</td>
                                        <td class="text-left">
                                            @switch($item->status)
                                                @case($productInOrderStatuses['wait_for_pick_up'])
                                                    Waiting for pick up
                                                @break
                                                @case($productInOrderStatuses['picked_up'])
                                                    Picked Up
                                                @break
                                                @case($productInOrderStatuses['returned_good'])
                                                    All products returned
                                                @break
                                                @case($productInOrderStatuses['returned_bad'])
                                                    All products returned
                                                @break
                                                @case($productInOrderStatuses['some_returned_good'])
                                                    Some products returned
                                                @break
                                                @case($productInOrderStatuses['some_returned_bad'])
                                                    Some products returned
                                                @break
                                                @case($productInOrderStatuses['cancel'])
                                                    Cancelled
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="text-right">
                                            <div style="display: flex">
                                                @if(in_array($item->status, $activeStatuses))
                                                <a class="btn btn-primary"
                                                    href="{{route('client.extendRentTime', ['productInOrderId' => $item->id])}}">
                                                    Extend Rent Time
                                                </a>
                                                @endif
                                                @if($item->status === $productInOrderStatuses['wait_for_pick_up'])
                                                <button class="cancel-button btn btn-danger"
                                                    data-url="{{ route('client.cancelOrderItem', ['productInOrderId' => $item->id]) }}">
                                                    cancel
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="buttons clearfix">
                    <div class="pull-left"><a href="{{ route('client.orderHistory') }}" class="btn btn-primary">Back to order history</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.cancel-button').on('click', function() {
                let url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(res) {
                        let selector = '#table-container';
                        let urlUpdate = window.location.href + " " + selector;
                        $(selector).load(urlUpdate);
                        Swal.fire({
                            text: res.message,
                            icon: 'success',
                        })
                    }
                });
            });
        });
    </script>
@endsection
