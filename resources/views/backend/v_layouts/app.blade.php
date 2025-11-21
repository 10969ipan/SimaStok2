<!doctype html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="WP2, Toko Online, Laravel" />
    <meta name="author" content="SimaStok" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>SimaStok - {{ $judul ?? 'Dashboard' }}</title>
    
    <link rel="shortcut icon" href="{{ asset('backend/image/sima.png') }}" />

    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('backend/concept-master/assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/concept-master/assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    
    @stack('styles')
</head>

<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="{{ route('backend.beranda') }}">
                    <img src="{{ asset('backend/image/sima.png') }}" style="width: 50px; height: auto; margin-right: 10px;" alt="Logo">
                    SimaStok
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Cari data..">
                            </div>
                        </li>

                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('backend/concept-master/assets/images/avatar-1.jpg') }}" alt="" class="user-avatar-md rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->nama ?? 'User' }}</h5>
                                    <span class="status"></span><span class="ml-2">Online</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Profil Saya</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Pengaturan</a>
                                
                                <form action="{{ route('backend.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger" style="cursor: pointer; background: none; border: none; width: 100%; text-align: left;">
                                        <i class="fas fa-power-off mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu Utama
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('backend/beranda') ? 'active' : '' }}" href="{{ route('backend.beranda') }}">
                                    <i class="fa fa-fw fa-user-circle"></i>Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('backend/user*', 'backend/supplier*', 'backend/pelanggan*', 'backend/bahan_baku*') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-master" aria-controls="submenu-master">
                                    <i class="fa fa-fw fa-database"></i>Master Data
                                </a>
                                <div id="submenu-master" class="collapse submenu {{ request()->is('backend/user*', 'backend/supplier*', 'backend/pelanggan*', 'backend/bahan_baku*') ? 'show' : '' }}" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.user.index') ? 'active' : '' }}" href="{{ route('backend.user.index') }}">User</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.supplier.index') ? 'active' : '' }}" href="{{ route('backend.supplier.index') }}">Supplier</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.pelanggan.index') ? 'active' : '' }}" href="{{ route('backend.pelanggan.index') }}">Pelanggan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.bahan_baku.index') ? 'active' : '' }}" href="{{ route('backend.bahan_baku.index') }}">Bahan Baku</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('backend/kategori*', 'backend/produk*', 'backend/desain_koleksi*') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-katalog" aria-controls="submenu-katalog">
                                    <i class="fas fa-fw fa-tag"></i>Katalog Produk
                                </a>
                                <div id="submenu-katalog" class="collapse submenu {{ request()->is('backend/kategori*', 'backend/produk*', 'backend/desain_koleksi*') ? 'show' : '' }}" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.kategori.index') ? 'active' : '' }}" href="{{ route('backend.kategori.index') }}">Kategori</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.produk.index') ? 'active' : '' }}" href="{{ route('backend.produk.index') }}">Produk Utama</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.produk_fashion.index') ? 'active' : '' }}" href="{{ route('backend.produk_fashion.index') }}">Produk Fashion</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.desain_koleksi.index') ? 'active' : '' }}" href="{{ route('backend.desain_koleksi.index') }}">Desain Koleksi</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('backend/produksi*', 'backend/penjualan*') ? 'active' : '' }}" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-transaksi" aria-controls="submenu-transaksi">
                                    <i class="fas fa-fw fa-shopping-cart"></i>Transaksi
                                </a>
                                <div id="submenu-transaksi" class="collapse submenu {{ request()->is('backend/produksi*', 'backend/penjualan*') ? 'show' : '' }}" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.produksi.index') ? 'active' : '' }}" href="{{ route('backend.produksi.index') }}">Produksi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('backend.penjualan.index') ? 'active' : '' }}" href="{{ route('backend.penjualan.index') }}">Penjualan</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('backend.laporan.index') ? 'active' : '' }}" href="{{ route('backend.laporan.index') }}">
                                    <i class="fas fa-fw fa-file-alt"></i>Laporan
                                </a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">{{ $judul ?? 'Halaman' }}</h2>
                            <p class="pageheader-text">Sistem Informasi Manajemen Stok.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}" class="breadcrumb-link">SimaStok</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $judul ?? '' }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
                </div>
            
            
            </div>
        </div>
    <script src="{{ asset('backend/concept-master/assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('backend/concept-master/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('backend/concept-master/assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('backend/concept-master/assets/libs/js/main-js.js') }}"></script>
    
    @if(request()->is('backend/beranda'))
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/morris-bundle/morris.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/c3charts/c3.min.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
        <script src="{{ asset('backend/concept-master/assets/libs/js/dashboard-ecommerce.js') }}"></script>
    @endif

    @stack('scripts')
</body>
 
</html>