@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Publishers Detail</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.publishers.detail', $publisher)}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success alert-dismissible">
                {{ session('message') }}
            </div>
        @endif
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Info</h5>
                        <div class="table-responsive">
                            <table class="table table-breviewless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Publisher Name :</th>
                                        <td class="text-muted">{{ $publisher->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Publisher Slug :</th>
                                        <td class="text-muted">{{ $publisher->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Created Date :</th>
                                        <td class="text-muted">{{ $publisher->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Last Update :</th>
                                        <td class="text-muted">{{ $publisher->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Status :</th>
                                        <td class="text-muted">{!! $publisher->status == 1 ? '<span class="text-success">show</span>' : '<span class="text-danger">hidden</span>' !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card body -->
                </div>
            </div><!-- end col -->
            <div class="col-lg-12">
                <div class="hstack gap-2 justify-content-start">
                    <a href="{{route('admin.publishers.edit', ['publisher' => $publisher->id])}}" type="submit" class="btn btn-primary">Edit</a>
                    <form method="POST" action="{{route('admin.publishers.destroy', ['publisher' => $publisher->id])}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="delete-btn"
                        >Delete</button>
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
