<aside id="column-left" class="col-sm-3 hidden-xs">
    @if(Auth::check())
    <div class="box">
        <div class="box-heading">Tài khoản</div>
        <div class="list-group">
            <a href="{{route('client.users.edit')}}" class="list-group-item">Tài khoản của tôi</a> <a
                href="{{route('client.likedProducts')}}" class="list-group-item">Yêu thích</a> <a
                href="{{route('client.orderHistory')}}" class="list-group-item">Lịch sử đặt hàng</a>
        </div>
    </div>
    @endif
    <div class="box">
        <div class="box-heading">Thông tin</div>
        <div class="list-group">
            <a class="list-group-item" href="{{route('aboutUs')}}">Về chúng tôi</a>
        </div>
    </div>
</aside>
