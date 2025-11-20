<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="WP2, Toko Online, Laravel" />
    <meta name="author" content="ANAK BAIK" />
    <meta name="robots" content="noindex,nofollow" />
    <title>SimaStok - Toko Online</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/image/icon_univ_bsi.png') }}" />

    <link href="{{ asset('backend/matrix-admin-bt5-master/assets/libs/flot/css/float-chart.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/matrix-admin-bt5-master/dist/css/style.min.css') }}" rel="stylesheet" />
    
    <style>
        /* Override Header menjadi Biru */
        .topbar .navbar-header {
            background: #1a9bfc !important; /* Biru Terang */
        }
        .topbar .navbar-collapse {
            background: #27a9e3 !important; /* Biru sedikit gelap untuk navbar */
        }
        /* Sidebar Putih dengan Border */
        .left-sidebar {
            background: #ffffff !important;
            border-right: 1px solid #e9ecef;
        }
        /* Warna Text Sidebar menjadi Gelap/Biru */
        .sidebar-nav ul .sidebar-item .sidebar-link {
            color: #54667a !important;
        }
        .sidebar-nav ul .sidebar-item .sidebar-link i {
            color: #1a9bfc !important; /* Icon Biru */
        }
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link {
            background: #ebf3f5 !important; /* Highlight Biru Pudar */
            color: #1a9bfc !important;
            font-weight: 600;
        }
        /* Hover Effect */
        .sidebar-nav ul .sidebar-item .sidebar-link:hover {
            background: #f2f7f8 !important;
        }
    </style>
  </head>

  <body>
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
      data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
      
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <a class="navbar-brand" href="{{ route('backend.beranda') }}">
              <b class="logo-icon ps-2">
                <img src="{{ asset('backend/image/icon_univ_bsi.png') }}" alt="homepage" class="light-logo" width="25" />
              </b>
              <span class="logo-text ms-2">
                 <span class="text-white font-weight-bold" style="font-size: 1.2em;">SimaStok</span>
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
                  <img src="{{ asset('backend/matrix-admin-bt5-master/assets/images/users/1.jpg') }}" alt="user" class="rounded-circle" width="31" />
                  <span class="text-white ms-2 font-weight-medium">{{ Auth::user()->nama ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#"><i class="mdi mdi-account me-1 ms-1"></i> Profil Saya</a>
                  <div class="dropdown-divider"></div>
                  <form action="{{ route('backend.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger"><i class="fa fa-power-off me-1 ms-1"></i> Logout</button>
                  </form>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <aside class="left-sidebar" data-sidebarbg="skin6">
        <div class="scroll-sidebar">
          <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
              
              <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item {{ request()->is('backend/beranda') ? 'selected' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('backend.beranda') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-database"></i><span class="hide-menu">Master Data</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="{{ route('backend.user.index') }}" class="sidebar-link"><i class="mdi mdi-account-key"></i><span class="hide-menu">User</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.supplier.index') }}" class="sidebar-link"><i class="mdi mdi-truck"></i><span class="hide-menu">Supplier</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.pelanggan.index') }}" class="sidebar-link"><i class="mdi mdi-account-group"></i><span class="hide-menu">Pelanggan</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.bahan_baku.index') }}" class="sidebar-link"><i class="mdi mdi-needle"></i><span class="hide-menu">Bahan Baku</span></a></li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-tshirt-crew"></i><span class="hide-menu">Katalog Produk</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="{{ route('backend.kategori.index') }}" class="sidebar-link"><i class="mdi mdi-tag"></i><span class="hide-menu">Kategori</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.produk.index') }}" class="sidebar-link"><i class="mdi mdi-package-variant"></i><span class="hide-menu">Produk Utama</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.produk_fashion.index') }}" class="sidebar-link"><i class="mdi mdi-sunglasses"></i><span class="hide-menu">Produk Fashion</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.desain_koleksi.index') }}" class="sidebar-link"><i class="mdi mdi-palette"></i><span class="hide-menu">Desain Koleksi</span></a></li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-cart"></i><span class="hide-menu">Transaksi</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="{{ route('backend.produksi.index') }}" class="sidebar-link"><i class="mdi mdi-factory"></i><span class="hide-menu">Produksi</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('backend.penjualan.index') }}" class="sidebar-link"><i class="mdi mdi-cash-register"></i><span class="hide-menu">Penjualan</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('backend.laporan.index') }}" aria-expanded="false">
                                <i class="mdi mdi-file-document-box"></i><span class="hide-menu">Laporan</span>
                            </a>
                        </li>
                    </ul>
                  </li>
                </ul>
              </li>
              
              

            </ul>
          </nav>
        </div>
      </aside>

      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title text-primary">{{ $judul ?? 'Dashboard' }}</h4>
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

        <div class="container-fluid">
          @yield('content')
        </div>

        <footer class="footer text-center">
          Developed by <a href="https://www.instagram.com/10969ipan" target="_blank">ANAK BAIK</a>.
        </footer>
      </div>
    </div>

    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/dist/js/waves.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/matrix-admin-bt5-master/dist/js/custom.min.js') }}"></script>
    
    @stack('scripts') 
  </body>
</html>