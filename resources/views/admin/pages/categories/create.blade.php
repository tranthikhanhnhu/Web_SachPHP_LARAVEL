@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Category</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.categories.create')}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Category Informations</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label">Name</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="name" class="form-control" id="name-input"
                                            placeholder="Enter category name" value="{{old('name')}}">
                                        @error('name')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="slugInput" class="form-label">Slug</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="slug" class="form-control" id="slug-input"
                                            placeholder="Enter category slug" value="{{old('slug')}}">
                                        @error('slug')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Status</label>
                                    </div>
                                    <div class="col-lg-9 d-flex">
                                        <div class="col-lg-6 form-radio-success">
                                            <input class="form-check-input" type="radio" name="status" value="1"
                                                id="status1"
                                                @if(!is_null(old('status')) && (int)old('status') === 1)
                                                checked
                                                @elseif(is_null(old('status')))
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="status1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="col-lg-6 form-radio-danger">
                                            <input class="form-check-input danger" type="radio" name="status" value="0"
                                                id="status2"
                                                @if(!is_null(old('status')) && (int)old('status') === 0)
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="status2">
                                                Blocked
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                        <div class="d-none code-view">
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

        </div>
    @endsection


@section('custom-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#name-input').on('keyup', function() {
            let name = $(this).val();
            $.ajax({
                method: 'POST',
                url: "{{route('admin.categories.getSlug')}}",
                data: {
                    name: name,
                    _token: "{{csrf_token()}}"
                },
                success: function(res) {
                    $('#slug-input').val(res);
                },
                error: function(res) {

                }
            })
        });
    });
</script>
@endsection
