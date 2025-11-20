<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="WP2" />
    <meta name="author" content="Naurah Sallsabila" />
    <meta name="description" content="Project Toko Online Mata Kuliah Web Programming UBSI" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Toko Online</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/image/icon_univ_bsi.png') }}" />

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/matrix-admin-bt5-master/asset/extra-libs/multicheck/multicheck.css') }}" />
    <link href="{{ asset('backend/matrix-admin-bt5-master/asset/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/matrix-admin-bt5-master/dist/css/style.min.css') }}" rel="stylesheet" />
  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper -->
    <!-- ============================================================== -->
    <div id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <a class="navbar-brand" href="{{ route('backend.beranda') }}">
              <b class="logo-icon ps-2">
                <img src="{{ asset('backend/image/icon_univ_bsi.png') }}" alt="homepage" class="light-logo" width="25" />
              </b>
              <span class="logo-text ms-2">
                <img src="{{ asset('backend/image/logo_text.png') }}" alt="homepage" class="light-logo" />
              </span>
            </a>
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
              <i class="ti-menu ti-close"></i>
            </a>
          </div>

          <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                  <i class="mdi mdi-menu font-24"></i>
                </a>
              </li>
            </ul>

            <ul class="navbar-nav float-end">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="{{ asset('backend/matrix-admin-bt5-master/asset/images/users/1.jpg') }}" alt="user" class="rounded-circle" width="31" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
                  <a class="dropdown-item" href="#"><i class="mdi mdi-wallet me-1 ms-1"></i> My Balance</a>
                  <a class="dropdown-item" href="#"><i class="mdi mdi-email me-1 ms-1"></i> Inbox</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#"><i class="mdi mdi-settings me-1 ms-1"></i> Account Setting</a>
                  <div class="dropdown-divider"></div>
                  <form action="{{ route('backend.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="fa fa-power-off me-1 ms-1"></i> Logout</button>
                  </form>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <!-- ============================================================== -->
      <!-- Sidebar -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <div class="scroll-sidebar">
          <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('backend.beranda') }}" aria-expanded="false">
                  <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('backend.user.index') }}" aria-expanded="false">
                  <i class="mdi mdi-account"></i><span class="hide-menu">User</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <i class="mdi mdi-face"></i><span class="hide-menu">Data Produk</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Kategori</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu">Produk</span></a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </aside>

      <!-- ============================================================== -->
      <!-- Page wrapper -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">{{ $judul ?? 'Halaman' }}</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $judul ?? '' }}</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================================================== -->
        <!-- Container fluid -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          @yield('content')
        </div>

        <!-- ============================================================== -->
        <!-- Footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
          Web Programming 2, Studi Kasus Toko Online
          <a href="https://www.instagram.com/navelv9" target="_blank">Naurah Sallsabila</a>.
        </footer>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- Scripts -->
    <!-- ============================================================== -->
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/dist/js/waves.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/dist/js/custom.min.js') }}"></script>
  </body>
</html>
