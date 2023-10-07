<aside id="column-left" class="col-sm-3 hidden-xs">
    @if(Auth::check())
    <div class="box">
        <div class="box-heading">Account</div>
        <div class="list-group">
            <a href="{{route('client.users.edit')}}" class="list-group-item">My Account</a> <a
                href="{{route('client.likedProducts')}}" class="list-group-item">Wish List</a> <a
                href="{{route('client.orderHistory')}}" class="list-group-item">Order History</a>
        </div>
    </div>
    @endif
    <div class="box">
        <div class="box-heading">Information</div>
        <div class="list-group">
            <a class="list-group-item" href="{{route('aboutUs')}}">About
                Us</a>
        </div>
    </div>
</aside>
