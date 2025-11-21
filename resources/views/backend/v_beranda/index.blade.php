@extends('backend.v_layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h5 class="card-title">Halo, {{ Auth::user()->nama }}!</h5>
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">Selamat Datang di SimaStok</h4>
                    <p>Anda login sebagai <strong>{{ Auth::user()->role == 1 ? 'Admin' : 'User' }}</strong>. Silakan gunakan menu di sidebar untuk mengelola data.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-cyan text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-tshirt-crew"></i></h1>
                <h6 class="text-white">Total Produk</h6>
                <h4 class="text-white">{{ $total_produk }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-truck"></i></h1>
                <h6 class="text-white">Total Supplier</h6>
                <h4 class="text-white">{{ $total_supplier }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-warning text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-account-multiple"></i></h1>
                <h6 class="text-white">Total Pelanggan</h6>
                <h4 class="text-white">{{ $total_pelanggan }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-danger text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-cart-outline"></i></h1>
                <h6 class="text-white">Total Penjualan</h6>
                <h4 class="text-white">{{ $total_penjualan }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-0">Transaksi Penjualan Terakhir</h4>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="bg-light text-primary">
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->tgl_penjualan)->format('d M Y') }}</td>
                                    <td class="fw-bold">{{ $row->pelanggan->nama_pelanggan ?? '-' }}</td>
                                    <td>{{ $row->user->nama ?? '-' }}</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
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
</div>



@endsection