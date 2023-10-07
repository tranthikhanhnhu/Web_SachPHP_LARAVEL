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
    <style>
        th, td, tr {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Order Email</h1>
    <div>Customer Name : {{ $order->user->userInfo->first_name }} {{$order->user->userInfo->last_name}}</div>
    <div>Customer Email : {{ $order->user->email }}</div>
    <div>Customer Phone : {{ $order->user->phone_number }}</div>
    <h1>Order Email</h1>
    <table class="table" style="margin-bottom: 0px">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Product Name</th>
            <th scope="col">Total Price</th>
            <th scope="col">Deposit</th>
            <th scope="col">Quantity</th>
            <th scope="col">Rent Time</th>
            <th scope="col">Pick Up Date</th>
            <th scope="col">Return Date</th>
        </tr>
        @php 
        $total = 0;
        $total_deposit = 0;
        @endphp
        @foreach($order->productsInOrder as $item)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ number_format($item->product_price) }}đ</td>
                <td>{{ number_format($item->deposit) }}đ</td>
                <td>{{ $item->product_quantity }}</td>
                <th>{{ $item->rent_time }}</td>
                <td>{{ $item->expected_pick_up_date }}</td>
                <td>{{ $item->expected_return_date }}</td>
            </tr>
            @php 
            $total += $item->product_price;
            $total_deposit += $item->deposit;
            @endphp
        @endforeach
    </table>
    <h3>Total: {{number_format($total)}}đ</h3>
    <h3>Total Deposit: {{number_format($total_deposit)}}đ</h3>
    <h3>Note: If you not go to shop to pick those products up, after 3 days or after the rental period end, those products will automatically cancel</h3>
</body>

</html>