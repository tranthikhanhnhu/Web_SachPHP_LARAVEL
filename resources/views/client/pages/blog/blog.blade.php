@extends('client.layout.master')

@section('body-class')
    class="information-blogger-blogs layout-2 left-col"
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

    <!-- ======= Quick view JS ========= -->
    <script>
        function quickbox() {
            if ($(window).width() > 767) {
                $('.quickview-button').magnificPopup({
                    type: 'iframe',
                    delegate: 'a',
                    preloader: true,
                    tLoading: 'Loading image #%curr%...',
                });
            }
        }
        jQuery(document).ready(function() {
            quickbox();
        });
        jQuery(window).resize(function() {
            quickbox();
        });
    </script>
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index9328.html?route=common/home"><i class="fa fa-home"></i></a></li>
            <li><a href="indexc295.html?route=information/blogger">Blogs</a></li>
        </ul>
        <div class="row">
            <aside id="column-left" class="col-sm-3 hidden-xs">
                <div class="box">
                    <div class="box-heading">Account</div>
                    <div class="list-group">
                        <a href="{{route('login')}}" class="list-group-item">Login</a> <a
                            href="{{route('signup')}}" class="list-group-item">Register</a> <a
                            href="indexacda.html?route=account/forgotten" class="list-group-item">Forgotten
                            Password</a>
                        <a href="indexe223.html?route=account/account" class="list-group-item">My Account</a>
                        <a href="indexe223.html?route=account/address" class="list-group-item">Address Book</a> <a
                            href="indexe223.html?route=account/wishlist" class="list-group-item">Wish List</a> <a
                            href="indexe223.html?route=account/order" class="list-group-item">Order History</a> <a
                            href="indexe223.html?route=account/download" class="list-group-item">Downloads</a><a
                            href="indexe223.html?route=account/recurring" class="list-group-item">Recurring
                            payments</a> <a href="indexe223.html?route=account/reward" class="list-group-item">Reward
                            Points</a> <a href="indexe223.html?route=account/return" class="list-group-item">Returns</a> <a
                            href="indexe223.html?route=account/transaction" class="list-group-item">Transactions</a> <a
                            href="indexe223.html?route=account/newsletter" class="list-group-item">Newsletter</a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-heading">Information</div>
                    <div class="list-group">
                        <a class="list-group-item"
                            href="index8816.html?route=information/information&amp;information_id=4">About Us</a>
                        <a class="list-group-item"
                            href="index1766.html?route=information/information&amp;information_id=6">Delivery
                            Information</a>
                        <a class="list-group-item"
                            href="index1679.html?route=information/information&amp;information_id=3">Privacy Policy</a>
                        <a class="list-group-item"
                            href="index99e4.html?route=information/information&amp;information_id=5">Terms &amp;
                            Conditions</a>
                        <a class="list-group-item" href="index2724.html?route=information/contact">Contact Us</a>

                        <a class="list-group-item" href="index7cb2.html?route=information/sitemap">Site Map</a>
                    </div>
                </div>
            </aside>
            <div id="content" class="col-sm-9 all-blog">
                <div class="allblog-top">
                    <h2 class="page-title">All Blogs</h2>
                </div>
                <div class="panel-default" style="padding-top: 5px;">
                    <h4>Latest Blog</h4>
                    <div class="panel panel-default blog-content">
                        <div class="panel-body blog-body">

                            <div class="blog-left-content">
                                <div class="blog-image">
                                    <img src="image/cache/catalog/7-1200x923.jpg" alt="Blogs" title="Blogs"
                                        class="img-thumbnail" />

                                    <p class="post_hover"><a class="icon zoom" title="Click to view Full Image "
                                            href="image/cache/catalog/7-1200x923.jpg" data-lightbox="example-set"><i
                                                class="fa fa-search-plus"></i> </a><a class="icon readmore_link"
                                            title="Click to view Read More "
                                            href="index4b1d.html?route=information/blogger&amp;blogger_id=4"><i
                                                class="fa fa-link"></i></a></p>

                                </div>

                            </div>
                            <h5><a href="index4b1d.html?route=information/blogger&amp;blogger_id=4">Blend into the
                                    Nature Lorem ipsum</a></h5>
                            <div class="blog-top">
                                <div class="write-comment"> <i class="fa fa-comment-o"></i> <a
                                        href="index4b1d.html?route=information/blogger&amp;blogger_id=4">10,298 Comment
                                        &nbsp; &nbsp;| </a> </div>
                                <div class="blog-date"> Jan 02, 2018</div>
                            </div>
                            <div class="blog-desc">Lorem ipsum dolor sit amet, consectetuer adipiscing. Aenean commodo
                                ligula eget dolor. Aen... </div>
                            <div class="blog-bottom">
                                <div class="read-more"> <a href="index4b1d.html?route=information/blogger&amp;blogger_id=4">
                                        read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default blog-content">
                        <div class="panel-body blog-body">

                            <div class="blog-left-content">
                                <div class="blog-image">
                                    <img src="image/cache/catalog/3-1200x923.jpg" alt="Blogs" title="Blogs"
                                        class="img-thumbnail" />

                                    <p class="post_hover"><a class="icon zoom" title="Click to view Full Image "
                                            href="image/cache/catalog/3-1200x923.jpg" data-lightbox="example-set"><i
                                                class="fa fa-search-plus"></i> </a><a class="icon readmore_link"
                                            title="Click to view Read More "
                                            href="indexaa69.html?route=information/blogger&amp;blogger_id=3"><i
                                                class="fa fa-link"></i></a></p>

                                </div>

                            </div>
                            <h5><a href="indexaa69.html?route=information/blogger&amp;blogger_id=3">Excepteur sint
                                    occaecat cupidatat</a></h5>
                            <div class="blog-top">
                                <div class="write-comment"> <i class="fa fa-comment-o"></i> <a
                                        href="indexaa69.html?route=information/blogger&amp;blogger_id=3">10,051 Comment
                                        &nbsp; &nbsp;| </a> </div>
                                <div class="blog-date"> Jan 02, 2018</div>
                            </div>
                            <div class="blog-desc">Contrary to popular belief, Lorem Ipsum is not simply random text.
                                It has roots in a piece... </div>
                            <div class="blog-bottom">
                                <div class="read-more"> <a
                                        href="indexaa69.html?route=information/blogger&amp;blogger_id=3"> read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default blog-content">
                        <div class="panel-body blog-body">

                            <div class="blog-left-content">
                                <div class="blog-image">
                                    <img src="image/cache/catalog/1-1200x923.jpg" alt="Blogs" title="Blogs"
                                        class="img-thumbnail" />

                                    <p class="post_hover"><a class="icon zoom" title="Click to view Full Image "
                                            href="image/cache/catalog/1-1200x923.jpg" data-lightbox="example-set"><i
                                                class="fa fa-search-plus"></i> </a><a class="icon readmore_link"
                                            title="Click to view Read More "
                                            href="index5463.html?route=information/blogger&amp;blogger_id=2"><i
                                                class="fa fa-link"></i></a></p>

                                </div>

                            </div>
                            <h5><a href="index5463.html?route=information/blogger&amp;blogger_id=2">Quisque egestas
                                    ullamco laboris sint</a></h5>
                            <div class="blog-top">
                                <div class="write-comment"> <i class="fa fa-comment-o"></i> <a
                                        href="index5463.html?route=information/blogger&amp;blogger_id=2">10,489 Comment
                                        &nbsp; &nbsp;| </a> </div>
                                <div class="blog-date"> Jan 02, 2018</div>
                            </div>
                            <div class="blog-desc">Lorem ipsum dolor sit amet, consectetuer adipiscing. Aenean commodo
                                ligula eget dolor. Aen... </div>
                            <div class="blog-bottom">
                                <div class="read-more"> <a
                                        href="index5463.html?route=information/blogger&amp;blogger_id=2"> read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default blog-content">
                        <div class="panel-body blog-body">

                            <div class="blog-left-content">
                                <div class="blog-image">
                                    <img src="image/cache/catalog/5-1200x923.jpg" alt="Blogs" title="Blogs"
                                        class="img-thumbnail" />

                                    <p class="post_hover"><a class="icon zoom" title="Click to view Full Image "
                                            href="image/cache/catalog/5-1200x923.jpg" data-lightbox="example-set"><i
                                                class="fa fa-search-plus"></i> </a><a class="icon readmore_link"
                                            title="Click to view Read More "
                                            href="index5a4b.html?route=information/blogger&amp;blogger_id=1"><i
                                                class="fa fa-link"></i></a></p>

                                </div>

                            </div>
                            <h5><a href="index5a4b.html?route=information/blogger&amp;blogger_id=1">Nostrum Iesum
                                    Christum cupidatat</a></h5>
                            <div class="blog-top">
                                <div class="write-comment"> <i class="fa fa-comment-o"></i> <a
                                        href="index5a4b.html?route=information/blogger&amp;blogger_id=1">16,533 Comment
                                        &nbsp; &nbsp;| </a> </div>
                                <div class="blog-date"> Jan 02, 2018</div>
                            </div>
                            <div class="blog-desc">Lorem ipsum dolor sit amet, consectetuer adipiscing. Aenean commodo
                                ligula eget dolor. Aen... </div>
                            <div class="blog-bottom">
                                <div class="read-more"> <a
                                        href="index5a4b.html?route=information/blogger&amp;blogger_id=1"> read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
