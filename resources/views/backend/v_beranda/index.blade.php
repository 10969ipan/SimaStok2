@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center pb-2">
                            <div class="dot-indicator bg-success mr-2"></div>
                            <p class="mb-0">Selamat Datang, <strong>{{ Auth::user()->nama }}</strong>!</p>
                        </div>
                        <p class="text-muted">Anda login sebagai <strong>{{ Auth::user()->role == 1 ? 'Admin' : 'User' }}</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-tshirt-crew text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Total Produk</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{ $total_produk }}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Data Produk Tersedia
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-truck text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Total Supplier</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{ $total_supplier }}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-account-box mr-1" aria-hidden="true"></i> Mitra Supplier
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-account-multiple text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Total Pelanggan</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{ $total_pelanggan }}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-emoticon-happy mr-1" aria-hidden="true"></i> Pelanggan Terdaftar
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-cart-outline text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Total Penjualan</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">{{ $total_penjualan }}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-cash-multiple mr-1" aria-hidden="true"></i> Transaksi Berhasil
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Transaksi Penjualan Terakhir</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>Kasir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksi_terakhir as $row)
                            <tr>
                                <td class="py-1">{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tgl_penjualan)->format('d M Y') }}</td>
                                <td>{{ $row->pelanggan->nama_pelanggan ?? '-' }}</td>
                                <td>{{ $row->user->nama ?? '-' }}</td>
                                <td>
                                    <label class="badge badge-success">Selesai</label>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data penjualan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection