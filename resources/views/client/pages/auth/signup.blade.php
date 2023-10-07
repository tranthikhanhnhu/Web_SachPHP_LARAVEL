@extends('client.layout.master')

@section('body-class')
    class="account-register layout-2 left-col"
@endsection



@section('content')
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
            {{Breadcrumbs::render('register')}}
        </ul>
        <div class="row">
            @include('client.pages.account_sidebar.account_sidebar')
            <div id="content" class="col-sm-9">
                <h1>Register</h1>
                <p>If you already have an account with us, please login at the <a
                       style="text-decoration:underline" href="{{route('login')}}">login page</a>.</p>
                <form action="{{route('storeUser')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <fieldset id="account">
                        <legend>Your Personal Details</legend>
                        <div class="form-group required" style="display: none;">
                            <label class="col-sm-2 control-label">Customer Group</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="customer_group_id" value="1" checked="checked" />
                                        Default</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" name="first_name" for="input-firstname">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="first_name" value="{{old('first_name')}}" placeholder="First Name"
                                    id="input-firstname" class="form-control" />
                                @error('first_name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" name="last_name" for="input-lastname">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="last_name" value="{{old('last_name')}}" placeholder="Last Name"
                                    id="input-lastname" class="form-control" />
                                @error('last_name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" value="{{old('email')}}" placeholder="E-Mail"
                                    id="input-email" class="form-control" />
                                @error('email')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-username">Username</label>
                            <div class="col-sm-10">
                                <input type="text" name="username" value="{{old('username')}}" placeholder="Username"
                                    id="input-username" class="form-control" />
                                @error('username')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-telephone">Telephone</label>
                            <div class="col-sm-10">
                                <input type="tel" name="phone_number" value="{{old('phone_number')}}" placeholder="Telephone"
                                id="input-telephone" class="form-control" />
                                @error('phone_number')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="1" 
                                    @if((int)old('gender') === 1) checked @endif />
                                    Male</label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="0" 
                                    @if(!is_null(old('gender')) && (int)old('gender') === 0) checked @endif  />
                                    Female</label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="" />
                                    Can't tell</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date of Birth</label>
                            <div class="col-sm-10">
                                <input type="date" name="dob" value="{{old('dob')}}" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="level" value="1">
                    </fieldset>
                    <fieldset>
                        <legend>Your Password</legend>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-password">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" value="" placeholder="Password"
                                    id="input-password" class="form-control" />
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-confirm">Password Confirm</label>
                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" value="" placeholder="Password Confirm"
                                    id="input-confirm" class="form-control" />
                                @error('password_confirmation')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <div class="buttons">
                        <div class="pull-right">
                            <input type="submit" value="Continue" class="btn btn-primary" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection