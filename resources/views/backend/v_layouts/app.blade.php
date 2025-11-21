<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="WP2, Toko Online, Laravel" />
    <meta name="author" content="ANAK BAIK" />
    <title>SimaStok - Toko Online</title>
    
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/css/vendor.bundle.addons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/css/demo_1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('backend/image/sima.png') }}" />

    {{-- Kustomisasi Gaya untuk Sidebar Putih --}}
    <style>
        /* Mengubah latar belakang sidebar menjadi putih */
        .sidebar {
            background-color: #ffffff !important;
        }
        /* Mengubah warna teks dan ikon di sidebar menjadi gelap agar terbaca */
        .sidebar .nav .nav-item .nav-link .menu-title,
        .sidebar .nav .nav-item .nav-link .menu-icon {
            color: #212529 !important; 
        }
        /* Mengubah latar belakang item menu aktif menjadi abu-abu terang */
        .sidebar .nav .nav-item.active > .nav-link {
            background: #f1f1f1 !important; 
            border-left: 3px solid #695acb; /* Menggunakan warna aksen yang diasumsikan */
        }
        /* Mengubah warna teks dan ikon item menu aktif kembali ke warna aksen */
        .sidebar .nav .nav-item.active > .nav-link .menu-title,
        .sidebar .nav .nav-item.active > .nav-link .menu-icon {
            color: #695acb !important; 
        }
        /* Memastikan warna teks untuk submenu juga gelap */
        .sidebar .nav .nav-item .collapse .nav-item .nav-link {
            color: #495057 !important;
        }
        .sidebar .nav .nav-item .collapse .nav-item.active .nav-link {
            color: #695acb !important;
        }
        /* Memastikan warna teks berubah saat hover */
        .sidebar .nav .nav-item .nav-link:hover,
        .sidebar .nav .nav-item .nav-link:focus {
            color: #695acb !important;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="{{ route('backend.beranda') }}">
            <img src="{{ asset('backend/image/sima.png') }}"  style="width: 30px; height: auto;" /> 
            <span class="font-weight-bold text-black ml-2" style="font-size: 20px;">SimaStok</span>
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ route('backend.beranda') }}">
            <img src="{{ asset('backend/image/sima.png') }}" style="width: 30px; height: auto;" />
          </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <span class="profile-text">Halo, {{ Auth::user()->nama ?? 'User' }} !</span>
                
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  
                  <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->nama ?? 'User' }}</p>
                  <p class="font-weight-light text-muted mb-0">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <a class="dropdown-item">Profil Saya <i class="dropdown-item-icon ti-user"></i></a>
                
                <form action="{{ route('backend.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Sign Out <i class="dropdown-item-icon ti-power-off"></i></button>
                </form>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      
      <div class="container-fluid page-body-wrapper">
        
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              

            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item {{ request()->is('backend/beranda') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('backend.beranda') }}">
                {{-- PERUBAHAN: Mengganti ikon typcn-document-text dengan mdi-view-dashboard --}}
                <i class="menu-icon mdi mdi-view-dashboard"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-master" aria-expanded="false" aria-controls="ui-master">
                {{-- PERUBAHAN: Mengganti ikon typcn-coffee dengan mdi-database --}}
                <i class="menu-icon mdi mdi-database"></i>
                <span class="menu-title">Master Data</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-master">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.user.index') }}">User</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.supplier.index') }}">Supplier</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.pelanggan.index') }}">Pelanggan</a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.bahan_baku.index') }}">Bahan Baku</a>
                  </li>
                </ul>
              </div>
            </li>

             <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-katalog" aria-expanded="false" aria-controls="ui-katalog">
                  {{-- PERUBAHAN: Mengganti ikon typcn-coffee dengan mdi-hanger (simbol pakaian/produk) --}}
                  <i class="menu-icon mdi mdi-hanger"></i>
                  <span class="menu-title">Katalog Produk</span>
                  <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-katalog">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('backend.kategori.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('backend.produk.index') }}">Produk Utama</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('backend.produk_fashion.index') }}">Produk Fashion</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" href="{{ route('backend.desain_koleksi.index') }}">Desain Koleksi</a>
                    </li>
                  </ul>
                </div>
              </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-transaksi" aria-expanded="false" aria-controls="ui-transaksi">
                  {{-- PERUBAHAN: Mengganti ikon typcn-coffee dengan mdi-cart --}}
                  <i class="menu-icon mdi mdi-cart"></i>
                  <span class="menu-title">Transaksi</span>
                  <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-transaksi">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('backend.produksi.index') }}">Produksi</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('backend.penjualan.index') }}">Penjualan</a>
                    </li>
                  </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('backend.laporan.index') }}">
                  {{-- PERUBAHAN: Mengganti ikon typcn-bell dengan mdi-file-document-box-outline --}}
                  <i class="menu-icon mdi mdi-file-document-box-outline"></i>
                  <span class="menu-title">Laporan</span>
                </a>
            </li>

          </ul>
        </nav>
        
        <div class="main-panel">
          <div class="content-wrapper">
            
            <div class="row page-title-header">
                <div class="col-12">
                    <div class="page-header">
                        <h4 class="page-title">{{ $judul ?? 'Dashboard' }}</h4>
                        <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                            <ul class="quick-links ml-auto">
                                <li><a href="{{ route('backend.beranda') }}">Home</a></li>
                                <li><a href="#">{{ $judul ?? '' }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')

          </div>
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2025 <a href="https://www.instagram.com/10969ipan" target="_blank">SimaStok</a>. All rights reserved.</span>
              
            </div>
          </footer>
          </div>
        </div>
      </div>
    <script src="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/js/shared/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/js/shared/misc.js') }}"></script>
    <script src="{{ asset('backend/StarAdmin-Free-Bootstrap-Admin-Template-master/src/assets/js/demo_1/dashboard.js') }}"></script>
    @stack('scripts')
  </body>
</html>