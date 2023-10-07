@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Products List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.products')}}
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
                                    <h4 class="card-title mb-0 flex-grow-1">Products</h4>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <a href="{{route('admin.products.create')}}" class="btn btn-primary">Create Products</a>
                                    <select id="sort-by" class="form-control mx-2" style="width: 120px">
                                        <option value="">---Sort by---</option>
                                        <option value="0" @if(!is_null(request()->sort_by) && request()->sort_by == 0) selected @endif>Latest</option>
                                        <option value="1" @if(!is_null(request()->sort_by) && request()->sort_by == 1) selected @endif>Oldest</option>
                                    </select>
                                    <button class="btn btn-light" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i
                                            class="fa-solid fa-filter"></i> Filter</button>
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control" id="search-input"
                                            placeholder="Search for products..." value="{{request()->keyword}}">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
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
                                            <th scope="col">Name</th>
                                            <th scope="col">Categories</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Publisher</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Book Layout</th>
                                            <th scope="col">Created Time</th>
                                            <th scope="col">updated Time</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td style="max-width: 200px; overflow:hidden; text-overflow:ellipsis">{{$product->name}}</td>
                                                <td style="max-width: 200px; overflow:hidden; text-overflow:ellipsis">
                                                    @foreach($product->categories as $key => $category)
                                                    @if($key > 0), @endif {{$category->name}}
                                                    @endforeach
                                                </td>
                                                <td>{{number_format($product->price)}}đ</td>
                                                <td>{{$product->publisher->name}}</td>
                                                <td>{{$product->origin->name}}</td>
                                                <td style="max-width: 200px; overflow:hidden; text-overflow:ellipsis">{{$product->author}}</td>
                                                <td>{{$product->book_layout === 0 ? 'paperback' : ($product->book_layout === 1 ? 'hardcover' : '')}}</td>
                                                <td>{{$product->created_at}}</td>
                                                <td>{{$product->updated_at}}</td>
                                                <td>
                                                    {!! $product->status === 1
                                                        ? '<span class="badge bg-success">show</span>'
                                                        : '<span class="badge bg-danger">hidden</span>' 
                                                    !!}
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.products.show', ['product' => $product->id])}}" type="button" class="btn btn-sm btn-light">Details</a>
                                                    <a href="{{route('admin.products.edit', ['product' => $product->id])}}" type="button" class="btn btn-sm btn-secondary">Edit</a>
                                                    <form class="d-inline" action="{{route('admin.products.changeStatus', ['product' => $product->id])}}" method="POST">
                                                        @csrf                                                            
                                                        @if($product->status === 1)
                                                            <input type="hidden" name="status" value="0">
                                                            <button type='submit' class='btn btn-sm btn-danger'>Hide</button>
                                                        @else
                                                            <input type="hidden" name="status" value="1">
                                                            <button type='submit' class='btn btn-sm btn-success'>Show</button>
                                                        @endif
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="13">
                                                {{$products->links('admin.pagination.custom')}}
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

    </div>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Products Filter</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 overflow-hidden">
            <div data-simplebar="init" style="height: calc(100vh - 112px);">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <form id="search-form" method="GET" action="" class="container">
                                        <div class="row p-3">
                                            <div class="col-xxl-12">
                                                <div>
                                                    <label for="status-input" class="form-label">Status</label>
                                                    <select class="form-control" name="status" id="status-input">
                                                        <option value="">--Choose status--</option>
                                                        <option value="1" @if(!is_null(request()->status) && request()->status == 1) selected @endif>Show</option>
                                                        <option value="0" @if(!is_null(request()->status) && request()->status == 0) selected @endif>Hidden</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-xxl-12">
                                                <div>
                                                    <label for="origins-input" class="form-label">Origin</label>
                                                    <select class="form-control" name="origins[]" id="origins-input">
                                                        <option value="">--Choose origin--</option>
                                                        @foreach ($origins as $origin)
                                                            <option value="{{$origin->slug}}" @if(request()->origins && request()->origins[0] === $origin->slug) selected @endif>{{$origin->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-xxl-12">
                                                <div>
                                                    <label for="publishers-input" class="form-label">Publisher</label>
                                                    <select class="form-control" name="publishers[]" id="publishers-input">
                                                        <option value="">--Choose publisher--</option>
                                                        @foreach ($publishers as $publisher)
                                                            <option value="{{$publisher->slug}}" @if(request()->publishers && request()->publishers[0] === $publisher->slug) selected @endif>{{$publisher->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-xxl-12">
                                                <div>
                                                    <label for="category-input" class="form-label">Category</label>
                                                    <select class="form-control" name="category" id="category-input">
                                                        <option value="">--Choose category--</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{$category->slug}}" @if(request()->category === $category->slug) selected @endif>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="sort-by-input" name="sort_by" value="{{request()->sort_by}}">
                                        <input type="hidden" name="keyword" id="keyword-input" value="{{request()->keyword}}">
                                        <div class="row p-3">
                                            <div class="col-xxl-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-light">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: auto; height: 987px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                    <div class="simplebar-scrollbar"
                        style="height: 763px; transform: translate3d(0px, 0px, 0px); display: block;">
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-foorter border p-3 text-center">
            2023 © Velzon.
        </div>
    </div>
@endsection



@section('custom-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#search-input').keypress(function (e) {
            if (e.which == 13) {
                $('#keyword-input').val($(this).val());
                $('#search-form').submit();
            }
        });
        $('#sort-by').on('change', function () {
            $('#sort-by-input').val($(this).val());
            $('#search-form').submit();
        });

        $(document).keydown(function(e) {
            if (e.ctrlKey && e.shiftKey && e.which == 65) {
                window.location.href = "{{route('admin.products.create')}}";
            }
        });
    });
</script>
@endsection

