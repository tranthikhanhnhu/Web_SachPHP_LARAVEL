@extends('admin.layout.vn_master')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi tiết thể loại</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{ Breadcrumbs::render('admin.categories.detail', $category) }}
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
                    <div class="card-body">
                        <h5 class="card-title mb-3">Thông tin</h5>
                        <div class="table-responsive">
                            <table class="table table-breviewless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Tên :</th>
                                        <td class="text-muted">{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Từ khóa :</th>
                                        <td class="text-muted">{{ $category->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Ngày tạo :</th>
                                        <td class="text-muted">{{ $category->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Lần cuối cập nhật :</th>
                                        <td class="text-muted">{{ $category->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Trạng thái :</th>
                                        <td class="text-muted">{!! $category->status == 1 ? '<span class="text-success">show</span>' : '<span class="text-danger">hidden<span>' !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Số lượng sản phẩm :</th>
                                        <td class="text-muted">{{ $category->products->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-start">
                    <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" type="submit"
                        class="btn btn-primary">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" id="delete-btn"
                            >Xóa</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
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
    </script>
@endsection
