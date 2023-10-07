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
    @php
        $today = explode('-', $today);
    @endphp
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
            {{Breadcrumbs::render('checkout')}}
        </ul>
        <div class="row">
            <div id="content" style="width: 100%">
                <div class="panel-collapse collapse in" id="collapse-checkout-option" aria-expanded="true" style="">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>Checkout</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div>Your Information:</div>
                <div>Phone number: {{ Auth::user()->phone_number }}</div>
                <div>Email: {{ Auth::user()->email }}</div>
                @if ($cart->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered shopping-cart">
                            <thead>
                                <tr>
                                    <td class="text-center">Image</td>
                                    <td class="text-left">Product Name</td>
                                    <td class="text-left">Quantity</td>
                                    <td class="text-left">Rent Time(days)</td>
                                    <td class="text-left">Pick up date</td>
                                    <td class="text-right">Unit Price</td>
                                    <td class="text-right">Deposit</td>
                                    <td class="text-right">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <form action=""></form>
                                @php
                                    $total = 0;
                                    $total_deposit = 0;
                                @endphp
                                @foreach ($cart as $item)
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
                                            <p>{{ $item->quantity }}</p>
                                        </td>
                                        <td class="text-left">
                                            <p>{{ $item->rent_time }}</p>
                                        </td>
                                        <td class="text-left">
                                            <div style="max-width: 200">
                                                <form method="POST" action={{ route('client.setPickUpDate') }}
                                                    id="set-pick-up-date-form{{ $item->id }}">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $item->product->id }}">
                                                    <p>Date: <input type="text" name="date"
                                                            id="datePicker{{ $item->id }}" class="datePicker">
                                                    </p>
                                                    @error('pick_up_date')
                                                        {{ $message }}
                                                    @enderror
                                                </form>
                                            </div>
                                            <?php
                                            $dates = findNotAvailableDays($item->product, $item->quantity, $item->rent_time);
                                            ?>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    var dates = [@foreach($dates as $date) '{{$date}}', @endforeach];

                                                    function DisableDates(date) {
                                                        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                                        return [dates.indexOf(string) == -1];
                                                    }
                                                    $('#datePicker{{ $item->id }}').datepicker({
                                                        beforeShowDay: DisableDates,
                                                        dateFormat: 'yy-mm-dd',
                                                        minDate: new Date({{ $today[0] }}, {{ $today[1] - 1 }},
                                                            {{ $today[2] }}),
                                                        maxDate: "+1Y",
                                                    });
                                                    $('#set-pick-up-date-form{{ $item->id }}').on('change', function() {
                                                        let url = $(this).attr('action');
                                                        let formData = $(this).serialize();
                                                        console.log(formData);
                                                        $.ajax({
                                                            method: 'POST',
                                                            url: url,
                                                            data: formData,
                                                            success: function(res) {},
                                                        });
                                                    })
                                                });
                                            </script>
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
                                        <td class="text-right">
                                            <div>{{ number_format($item->product->price * $item->quantity) }}đ</div>
                                        </td>
                                        <td class="text-right">
                                            {{ number_format(calculatePrice($item->product, $item->rent_time, $item->quantity)) }}đ
                                        </td>
                                    </tr>
                                    @php
                                        $total += calculatePrice($item->product, $item->rent_time, $item->quantity);
                                        $total_deposit += $item->product->price * $item->quantity;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div>Note: If you pick a big amount of a product, you may need to wait a long time for pick up date
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><strong>Total:</strong></td>
                                        <td class="text-right">{{ number_format($total) }}đ</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Total Deposit:</strong></td>
                                        <td class="text-right">{{ number_format($total_deposit) }}đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <button data-url="{{ route('client.placeOrder') }}" class="btn btn-primary"
                                id="order-btn">Order
                            </button>
                        </div>
                    </div>
                @else
                    <div class="row" style="font-size: 3rem; width: 100%; text-align: center">
                        There is nothing in your cart
                    </div>
                    <div class="row" style="text-align: center; margin-top: 10px">
                        <a href="{{ route('/') }}" class="btn btn-primary">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#order-btn').on('click', function() {

                let isEmpty = $('.datePicker').filter(function() {
                    return this.value == '';
                });

                if (isEmpty.length > 0) {
                    Swal.fire({
                        text: 'You need to select pick up date',
                        icon: 'error',
                    });
                } else {
                    window.location.href = $(this).data('url');
                }

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
