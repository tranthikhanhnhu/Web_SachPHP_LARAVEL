@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Products Detail</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.products.detail', $product)}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        @if (session('message'))
            {!! session('message') !!}
        @endif
        <!-- end page title -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm-auto">
                                <div>
                                    <h4 class="card-title mb-0 flex-grow-1">reviews</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Rating</th>
                                            <th scope="col">Content</th>
                                            <th scope="col">Created Time</th>
                                            <th scope="col" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                @for($i = 0; $i < $review->rating; $i++)
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x" style="color: #ffd218"></i></span>
                                                @endfor
                                                @for($i = 0; $i < (5 - $review->rating); $i++)
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
                                                @endfor
                                                </td>
                                                <td style="max-width: 300px; text-wrap: wrap">{{ $review->content }}</td>
                                                <td>{{ $review->created_at }}</td>
                                                <td>
                                                    <a href="{{route('admin.products.deleteReview', ['review' => $review->id])}}"
                                                        type="button" class="btn btn-sm btn-danger">Delete</a>
                                                    <form class="d-inline"
                                                        action="{{ route('admin.users.changeStatus', ['user' => $review->id]) }}"
                                                        method="POST">
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="13">
                                                {{ $reviews->appends(request()->query())->links('admin.pagination.custom') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Info</h5>
                        <div class="table-responsive">
                            <table class="table table-breviewless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Name:</th>
                                        <td class="text-muted">{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Slug:</th>
                                        <td class="text-muted">{{ $product->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Price:</th>
                                        <td class="text-muted">{{ number_format($product->price) }}đ</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">1 Day Rent Price:</th>
                                        <td class="text-muted">
                                            {{ number_format($product->rentPrice->firstWhere('number_of_days', 1)->price) }}đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">7 Days Rent Price:</th>
                                        <td class="text-muted">
                                            {{ number_format($product->rentPrice->firstWhere('number_of_days', 7)->price) }}đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">30 Days Rent Price:</th>
                                        <td class="text-muted">
                                            {{ number_format($product->rentPrice->firstWhere('number_of_days', 30)->price) }}đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">90 Days Rent Price:</th>
                                        <td class="text-muted">
                                            {{ number_format($product->rentPrice->firstWhere('number_of_days', 90)->price) }}đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Short Description:</th>
                                        <td class="text-muted">{{ $product->short_description }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Description:</th>
                                        <td class="text-muted">{!! $product->description !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Author:</th>
                                        <td class="text-muted">{{ $product->author }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Publisher:</th>
                                        <td class="text-muted">{{ $product->publisher->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Origin:</th>
                                        <td class="text-muted">{{ $product->origin->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Book Layout:</th>
                                        <td class="text-muted">
                                            {{ $product->book_layout === 0 ? 'paperback': 'hardcover' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Dimensions:</th>
                                        <td class="text-muted">{{ $product->height }} x {{ $product->width }}
                                            {{ !is_null($product->thickness) ? ' x ' . $product->thickness: '' }} cm</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Weight:</th>
                                        <td class="text-muted">{{ $product->weight }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Number Of Pages:</th>
                                        <td class="text-muted">{{ $product->number_of_pages }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Created Date:</th>
                                        <td class="text-muted">{{ $product->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Publish Year:</th>
                                        <td class="text-muted">{{ $product->publish_year }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Quantity:</th>
                                        <td class="text-muted">{{ $product->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Last Update:</th>
                                        <td class="text-muted">{{ $product->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Status:</th>
                                        <td class="text-muted">{{ $product->status == 1 ? 'show': 'hidden' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-start">
                    <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" type="submit"
                        class="btn btn-primary">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', ['product' => $product->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#delete-btn').click(function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                })
            });
        });
    </script>
@endsection
