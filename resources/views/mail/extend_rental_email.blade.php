<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{asset('client/js/jquery/jquery-2.1.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <h1>Order Email</h1>
    <div>Customer Name : {{ $item->order->user->userInfo->first_name }} {{$item->order->user->userInfo->last_name}}</div>
    <div>Customer Email : {{ $item->order->user->email }}</div>
    <div>Customer Phone : {{ $item->order->user->phone_number }}</div>
    <h1>Rental Extend Email</h1>

    <p>Your Rental of {{$item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity)}} product {{$item->product->name}} that have id {{$item->product->id}} had been extended</p>
    <p>Your new rent price is: {{number_format($item->product_price)}}đ</p>
    <p>Your new deposit return is: {{number_format($item->deposit_return)}}đ</p>
    <p>Your new return date is: {{date('Y-m-d', strtotime($item->expected_return_date))}}</p>

</body>

</html>