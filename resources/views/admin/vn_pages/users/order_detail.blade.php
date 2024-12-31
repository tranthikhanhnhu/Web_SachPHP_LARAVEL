@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi tiết đơn hàng</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.users.order', $order, $order->user)}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        @if (session('message'))
            {!! session('message') !!}
        @endif
        <!-- end page title -->

        @foreach ($order->productsInOrder as $item)
        <div class="row" style="margin-bottom: 30px">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Thông tin</h5>
                        <div class="table-responsive">
                            <table class="table table-breviewless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Tên sách:</th>
                                        <td class="text-muted">{{ $item->product_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Giá thuê 1 ngày</th>
                                        <td class="text-muted">{{ number_format($item->product->rentPrice->firstWhere('number_of_days', 1)->price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Giá thuê 7 ngày</th>
                                        <td class="text-muted">{{ number_format($item->product->rentPrice->firstWhere('number_of_days', 7)->price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Giá thuê 30 ngày</th>
                                        <td class="text-muted">{{ number_format($item->product->rentPrice->firstWhere('number_of_days', 30)->price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Giá thuê 90 ngày</th>
                                        <td class="text-muted">{{ number_format($item->product->rentPrice->firstWhere('number_of_days', 90)->price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Giá sản phẩm</th>
                                        <td class="text-muted">{{ number_format($item->product->price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Tổng tiền:</th>
                                        <td class="text-muted">{{ number_format($item->product_price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Số lượng:</th>
                                        <td class="text-muted">{{ $item->product_quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Thời gian thuê:</th>
                                        <td class="text-muted">{{ $item->rent_time }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Tổng tiền đặt cọc:</th>
                                        <td class="text-muted">{{ number_format($item->deposit) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Total Deposit Return:</th>
                                        <td class="text-muted">{{ number_format($item->deposit_return) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Expected Pick Up Date:</th>
                                        <td class="text-muted">{{ $item->expected_pick_up_date }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Picked Up Date:</th>
                                        <td class="text-muted">{{ $item->pick_up_date }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Expected Return Date:</th>
                                        <td class="text-muted">{{ $item->expected_return_date }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Returned Date:</th>
                                        <td class="text-muted">{{ $item->return_date }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Returned In Good Condition Quantity:</th>
                                        <td class="text-muted">{{ $item->returned_good_quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Returned In Bad Condition Quantity:</th>
                                        <td class="text-muted">{{ $item->returned_bad_quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Status:</th>
                                        <td class="text-muted">{{ $item->status }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Created Time:</th>
                                        <td class="text-muted">{{ $item->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Last Update:</th>
                                        <td class="text-muted">{{ $item->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Lated:</th>
                                        <td class="text-muted">{{ $item->lated === 1 ? 'true' : 'false' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-end">
                    @if($today < $item->expected_pick_up_date && $item->status !== $order_statuses['cancel'])
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['cancel']]) }}" type="submit"
                            class="btn btn-danger">Cancel</a>   
                    @elseif($item->status === $order_statuses['wait_for_pick_up'])
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['picked_up']]) }}" type="submit"
                            class="btn btn-primary">Picked Up</a>
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['cancel']]) }}" type="submit"
                            class="btn btn-danger">Cancel</a>
                    @elseif($item->status === $order_statuses['picked_up']
                    || $item->status === $order_statuses['some_returned_bad']
                    || $item->status === $order_statuses['some_returned_good'])
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['returned_good']]) }}" type="submit"
                            class="btn btn-success">1 Product Returned In Good Condition</a>
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['returned_bad']]) }}" type="submit"
                            class="btn btn-danger">1 Product Returned In Bad Condition</a>
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['returned_good'], 'returnedAll' => true]) }}" type="submit"
                            class="btn btn-success">All Products Returned In Good Condition</a>
                        <a href="{{ route('admin.orders.changeStatus', ['productInOrder' => $item->id, 'status' => $order_statuses['returned_bad'], 'returnedAll' => true]) }}" type="submit"
                            class="btn btn-danger">All Product Returned In Bad Condition</a>
                    @endif
                </div>
            </div>

        </div>
        @endforeach


    </div>
@endsection
