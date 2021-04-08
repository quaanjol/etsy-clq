<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ URL::asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ URL::asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('images/mario.png') }}" rel="icon">
    @yield('style')
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-{{$theme}} sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ Route('admin.dashboard') }}">
          <div class="sidebar-brand-icon">
            <i class="fas fa-kiss-wink-heart"></i>
          </div>
          <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item side-bar-item active" id="dashboardLi">
            <a class="nav-link" href="{{ Route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                Tổng quan
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Quản lí thông tin
        </div>

        <!-- Nav Item - Bigcommerce Menu -->
        <li class="nav-item side-bar-item" id="bigcommerceLi">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
            <i class="fab fa-fw fa-bootstrap"></i>
                Bigcommerce
            </a>
            <div id="collapseCategory" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Thao tác:</h6>
                    <a class="collapse-item" href="{{ route('bigcomoriginal.bsm.convert') }}">BS Management</a>
                    <a class="collapse-item" href="{{ route('bigcomoriginal.bso.convert') }}">BS Order Wong</a>
                    <a class="collapse-item" href="{{ route('bigcomoriginal.cvds.convert') }}">CV Order Dreamship</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Shopify Menu -->
        <li class="nav-item side-bar-item" id="shopifyLi">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRooms" aria-expanded="true" aria-controls="collapseRooms">
            <i class="fab fa-fw fa-shopify"></i>
                Shopify
            </a>
            <div id="collapseRooms" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Thao tác:</h6>
                    <a class="collapse-item" href="{{ route('shopify.cvds.convert') }}">Tạo file order</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Tracking Menu -->
        <li class="nav-item side-bar-item" id="trackingLi">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTracking" aria-expanded="true" aria-controls="collapseTracking">
            <i class="fas fa-fw fa-plane-departure"></i>
                DS Trackings
            </a>
            <div id="collapseTracking" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Thao tác:</h6>
                    <a class="collapse-item" href="{{ route('tracking.dreamship') }}">By order number</a>
                    <a class="collapse-item" href="{{ route('tracking.dreamship.afterdate') }}">By after date</a>
                    <a class="collapse-item" href="{{ route('tracking.dreamship.beforedate') }}">By before date</a>
                    <a class="collapse-item" href="{{ route('tracking.dreamship.betweendate') }}">By between date</a>
                </div>
            </div>
        </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Tiện ích
    </div>

    <!-- Nav Item - Palette color Menu -->
    <li class="nav-item side-bar-item" id="changeThemeLi">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-palette"></i>
        Đổi màu chủ đạo
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Bảy sắc màu:</h6>
            <a class="collapse-item text-artsyvv" href="{{route('theme.change', ['color' => 'artsyvv'])}}">Artsyv</a>
            <a class="collapse-item text-artsyv" href="{{route('theme.change', ['color' => 'artsyv'])}}">Artsyv 2</a>
            <a class="collapse-item text-artsyv2" href="{{route('theme.change', ['color' => 'artsyv2'])}}">Artsyv 3</a>
            <a class="collapse-item text-danger" href="{{route('theme.change', ['color' => 'danger'])}}">Đỏ</a>
            <a class="collapse-item text-success" href="{{route('theme.change', ['color' => 'success'])}}">Xanh lá</a>
            <a class="collapse-item text-warning" href="{{route('theme.change', ['color' => 'warning'])}}">Vàng</a>
            <a class="collapse-item text-primary" href="{{route('theme.change', ['color' => 'primary'])}}">Lục</a>
            <a class="collapse-item text-info" href="{{route('theme.change', ['color' => 'info'])}}">Lam</a>
            <a class="collapse-item text-secondary" href="{{route('theme.change', ['color' => 'secondary'])}}">Chàm</a>
            <a class="collapse-item text-dark" href="{{route('theme.change', ['color' => 'dark'])}}">Tối</a>
        </div>
    </div>
    </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" id="menu-nav">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

            <!-- Topbar Search -->
            <form action="" method="get" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                @csrf
                <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" 
                    placeholder="Tìm kiếm..." 
                    aria-label="Search" 
                    aria-describedby="basic-addon2" name="search" id="search">  
                <div class="input-group-append">
                    <button class="btn btn-{{$theme}}" type="button">
                    <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
                </div>
            </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $user->name }}</span>
              <img class="img-profile rounded-circle" src="https://i.imgur.com/jJ4Iy9p.png" style="object-fit: cover;">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ Route('admin.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Trang cá nhân
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> 
                    Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Message -->
        @foreach(['danger', 'warning', 'success', 'info'] as $msg)
            @if(session($msg))
            <div class="my-container">
                <div class="alert alert-{{$msg}}">
                    {{session($msg)}}
                </div>
            </div>
            @endif
        @endforeach

        <!-- Begin Page Content -->
        <div class="container-fluid" id="main-content">

            <!-- Page Heading -->
            <div class="mb-4">
                <h1 class="h3 mb-0 text-gray-800 text-center">
                    {{$heading["vietnamese"]}}
                </h1>
                {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
            </div>

          <!-- Content Row -->
            <div class="row">

            @yield('content')

            </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white" id="my-footer">
            <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; {{ config('app.name') }} <span id="current-year"></span></span>
                <script>
                    var present = new Date();
                    var thisYear = present.getFullYear();
                    document.getElementById('current-year').textContent = thisYear;
                </script>
            </div>
            <div class="copyright text-center mt-1">
              
            </div>
            </div>
        </footer>
        <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('admin/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{URL::asset('admin/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{URL::asset('admin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{URL::asset('admin/js/demo/chart-pie-demo.js')}}"></script>
    <script src="{{URL::asset('admin/js/active-link.js')}}"></script>
    @yield('scripts')
</body>

</html>
