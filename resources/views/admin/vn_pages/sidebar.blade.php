<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Danh mục</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Bảng điều khiển</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.index')}}" class="nav-link" data-key="t-analytics">
                                    Thống kê </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Người dùng</span>
                    </a>
                        <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.users.index')}}" class="nav-link" data-key="t-signin">
                                Danh sách người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.users.create')}}" class="nav-link"  data-key="t-signup">
                                Thêm mới người dùng</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span data-key="t-pages">Thể loại</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.categories.index')}}" class="nav-link" data-key="t-starter">
                                    Danh sách thể loại</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.categories.create')}}" class="nav-link" data-key="t-profile">
                                    Thêm mới thể loại
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarLanding">
                        <i class="ri-rocket-line"></i> <span data-key="t-landing">Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLanding">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.products.index')}}" class="nav-link" data-key="t-one-page">
                                Danh sách sản phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.products.create')}}" class="nav-link" data-key="t-nft-landing">
                                Thêm mới sản phẩm</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                        <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Nhà xuất bản</span>
                    </a>
                    <div class="menu-dropdown collapse" id="sidebarForms" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.publishers.index')}}" class="nav-link" data-key="t-form-select"> Danh sách nhà xuất bản </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.publishers.create')}}" class="nav-link" data-key="t-checkboxs-radios"> Thêm mới nhà xuất bản </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrigins" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrigins">
                        <i class="ri-honour-line"></i> <span data-key="t-forms">Nguyên tác</span>
                    </a>
                    <div class="menu-dropdown collapse" id="sidebarOrigins" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.origins.index')}}" class="nav-link" data-key="t-form-select"> Danh sách nhà nguyên tác </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.origins.create')}}" class="nav-link" data-key="t-checkboxs-radios">Thêm mới nguyên tác</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarClient" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarClient">
                        <i class="ri-stack-line"></i> <span data-key="t-Client">Trang khách hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarClient">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('/')}}" class="nav-link" data-key="t-one-page">
                                Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('client.products.index')}}" class="nav-link" data-key="t-nft-client">
                                Trang sản phẩm</a>
                            </li>
                        </ul>
                    </div>
                </li>

                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
