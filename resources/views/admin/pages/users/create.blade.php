@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create User</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.users.create')}}
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
                        <h4 class="card-title mb-0 flex-grow-1">User Informations</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-datas">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="firstNameInput" class="form-label">First Name</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="first_name" class="form-control" id="firstNameInput"
                                            placeholder="Enter user first name" value="{{old('first_name')}}">
                                        @error('first_name')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="lastNameInput" class="form-label">Last Name</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="last_name" class="form-control" id="lastNameInput"
                                            placeholder="Enter user last name" value="{{old('last_name')}}">
                                        @error('last_name')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="leaveemails" class="form-label">Email</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="email" name="email" class="form-control" id="leaveemails"
                                            placeholder="Enter user email" value="{{old('email')}}">
                                        @error('email')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="username" class="form-label">Username</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="username" class="form-control" id="username"
                                            placeholder="Enter user username number" value="{{old('username')}}">
                                        @error('username')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="phoneNumber" class="form-label">Phone Number</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="phone_number" class="form-control" id="phoneNumber"
                                            placeholder="Enter user phone number" value="{{old('phone_number')}}">
                                        @error('phone_number')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Enter user password">
                                        @error('password')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="password_confirmation" class="form-label">Password Confirm</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="password" name="password_confirmation" class="form-control" id="passowrd_confirmation"
                                            placeholder="Enter user password again">
                                        @error('password_confirmation')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Level</label>
                                    </div>
                                    <div class="col-lg-9 d-flex">
                                        <div class="col-lg-6">
                                            <input class="form-check-input" type="radio" name="level" value="1"
                                                id="formradioRight5"
                                                @if(!is_null(old('level')) && (int)old('level') === 1)
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="formradioRight5">
                                                Admin
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-check-input" type="radio" name="level" value="0"
                                                id="formradioRight6"
                                                @if(!is_null(old('level')) && (int)old('level') === 0)
                                                checked
                                                @elseif(is_null(old('level')))
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="formradioRight6">
                                                Client
                                            </label>
                                        </div>
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
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Date of Birth</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" name="dob" data-provider="flatpickr" id="dateInput" value="{{old('dob')}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="gender" class="form-label">Gender</label>
                                    </div>
                                    <div class="col-lg-9 d-flex">
                                        <div class="col-lg-4">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="gender1" value="1"
                                                @if(!is_null(old('gender')) && (int)old('gender') === 1)
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="gender1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="gender2" value="0"
                                                @if(!is_null(old('gender')) && (int)old('gender') === 0)
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="gender2">
                                                Female
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="gender3" value="{{null}}"
                                                @if(is_null(old('gender')))
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="gender3">
                                                Can't tell
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
