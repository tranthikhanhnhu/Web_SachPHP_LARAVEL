@extends('client.layout.master')

@section('body-class')
    class="account-login layout-2 left-col"
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
            {{Breadcrumbs::render('login')}}
        </ul>

        @if($errors->any())
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Thông báo: Email hoặc mật khẩu không trùng khớp.</div>
        @endif
        <div class="row">
            @include('client.pages.account_sidebar.account_sidebar')
            <div id="content" class="col-sm-9">
                <h1>Login</h1>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="well">
                            <h3>Khách hàng mới</h3>
                            <p><strong>Đăng ký tài khoản</strong></p>
                            <p></p>Với việc tạo tài khoản bạn sẽ có thể mua hàng nhanh hơn, nắm bắt được thông tin đơn hàng, và năm được thông tin đơn hàng trước đó của bạn.</p>
                            <a href="{{route('signup')}}" class="btn btn-primary">Tiếp tục</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="well">
                            <h3>Đăng nhập</h3>
                            <form action="{{route('postLogin')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label" for="input-email">Địa chỉ email</label>
                                    <input type="text" name="email" value="{{old('email')}}" placeholder="E-Mail Address"
                                        id="input-email" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="input-password">Mật khẩu</label>
                                    <input type="password" name="password" value="" placeholder="Password"
                                        id="input-password" class="form-control" />
                                </div>
                                <input type="submit" value="Login" class="btn btn-primary" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
