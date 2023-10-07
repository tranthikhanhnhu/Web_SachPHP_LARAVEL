@extends('client.layout.master')

@section('body-class')
    class="account-login layout-2 left-col"
@endsection


@section('content')

    @if (session('message'))
    <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            text: '{{session("message")}}',
        });
    </script>
    @endif
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
            {{Breadcrumbs::render('extendRentTime', $item, $item->order)}}
        </ul>
        <div class="row">
            <div id="content" style="width: 100%">
                <div class="panel-collapse collapse in" id="collapse-checkout-option" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Extend Rent Time</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div>Your Information:</div>
                <div>Phone number: {{ Auth::user()->phone_number }}</div>
                <div>Email: {{ Auth::user()->email }}</div>
                <div class="table-responsive">
                    <form action="{{route('client.postExtendRentTime')}}" method="POST" id="extend-time-form">
                        @csrf
                        <input type="hidden" name="productInOrderId" value="{{$item->id}}">
                        <table class="table table-bordered shopping-cart">
                            <thead>
                                <tr>
                                    <td class="text-center">Image</td>
                                    <td class="text-left">Product Name</td>
                                    <td class="text-left">Quantity</td>
                                    <td class="text-left">Current Rent Time</td>
                                    <td class="text-left">Current Return Date</td>
                                    <td class="text-left">Time Extend</td>
                                    <td class="text-left">Unit Price</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><img
                                            src="{{ asset("images/products/{$item->product->productImages->firstWhere('type', 1)->image_url}") }}"
                                            alt="ut labore et dolore magnam aliquam quae"
                                            title="ut labore et dolore magnam aliquam quae" class="img-thumbnail"
                                            style="height: 80px">
                                    </td>
                                    <td class="text-left">
                                        <p>{{ $item->product->name }}</p>
                                    </td>
                                    <td class="text-left">
                                        <p>{{ $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity) }}</p>
                                    </td>
                                    <td class="text-left">
                                        <p>{{ $item->rent_time }} day(s)</p>
                                    </td>
                                    <td class="text-left">
                                        <p>{{ $item->expected_return_date }}</p>
                                    </td>
                                    <td class="text-left">
                                        <select 
                                        class="form-control" 
                                        name="extend_time" 
                                        id="extend-time-input"
                                        data-url="{{route('client.getItemTotal', ['productInOrder' => $item->id])}}">
                                            <option value="0">--Selected Extend Time--</option>
                                            <option value="1" @if(getMaxExtendTime($item->product, $item) < 1) disabled @endif>1 Day</option>
                                            <option value="3" @if(getMaxExtendTime($item->product, $item) < 3) disabled @endif>3 Days</option>
                                            <option value="7" @if(getMaxExtendTime($item->product, $item) < 7) disabled @endif>7 Days</option>
                                            <option value="30" @if(getMaxExtendTime($item->product, $item) < 30) disabled @endif>30 Days</option>
                                            <option value="90" @if(getMaxExtendTime($item->product, $item) < 90) disabled @endif>90 Days</option>
                                        </select>
                                    </td>
                                    <td class="text-right">
                                        <div>
                                            {{ number_format($item->product->rentPrice->firstWhere('number_of_days', 1)->price) }}đ/1day
                                        </div>
                                        <div>
                                            {{ number_format($item->product->rentPrice->firstWhere('number_of_days', 7)->price) }}đ/7day
                                        </div>
                                        <div>
                                            {{ number_format($item->product->rentPrice->firstWhere('number_of_days', 30)->price) }}đ/30day
                                        </div>
                                        <div>
                                            {{ number_format($item->product->rentPrice->firstWhere('number_of_days', 90)->price) }}đ/90day
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <br>
                <div>Note: If there are some customer that booked for rent this product, you may not be able to extend your rental
                </div>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-right"><strong>Total:</strong></td>
                                    <td class="text-right" id="total-field">{{ number_format(calculatePrice($item->product, 0, $item->product_quantity  - ($item->returned_good_quantity + $item->returned_bad_quantity)))}}đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="buttons clearfix">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" id="extend-btn">Extend
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#extend-btn').on('click', function() {

                if ($('#extend-time-input').val() == '0') {
                    Swal.fire({
                        text: 'You cannot extend 0 day',
                        icon: 'error',
                    });
                } else {
                    $('#extend-time-form').submit();
                }

            });

            $('#extend-time-input').on('change', function() {
                let url = $(this).data('url');
                let rent_time = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: url + '/' + rent_time,
                    success: function(res) {
                        $('#total-field').html(res.total + 'đ');
                    },
                });
            });


            $('.set-pick-up-date-form').on('change', function() {
                let url = $(this).attr('action');
                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: formData,
                    success: function(res) {},
                });
            });

        });
    </script>
@endsection
