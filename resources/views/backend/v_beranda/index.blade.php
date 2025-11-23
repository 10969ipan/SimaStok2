@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Selamat Datang, <strong>{{ Auth::user()->nama }}</strong>!</p>
                    </div>
                        <p class="text-muted">Anda login sebagai <strong>{{ Auth::user()->role == 1 ? 'Admin' : 'User' }} </strong>.</p>
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
                        <i class="mdi mdi-tshirt-crew text-info icon-lg"> <style>i{font-size: 1c.0em;}</style></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Total Produk</p>
                        <div class="fluid-container">
                            <h3 class="font weight-height-medium text-right mb-0">{{ $total_produk }}</h3>
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
                <h4 class="card-title">Aktivitas Terakhir</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Nama Item</th>
                                <th>Keterangan</th> <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aktivitas_terakhir as $row)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('d M Y H:i') }}</td>
                                
                                <td>
                                    @if($row->tipe == 'Produk')
                                        <label class="badge badge-info">Produk</label>
                                    @else
                                        <label class="badge badge-warning">Bahan Baku</label>
                                    @endif
                                </td>

                                <td>{{ $row->nama }}</td>

                                <td>
                                    @if($row->created_at == $row->updated_at)
                                        <span class="text-primary">
                                            <i class="mdi mdi-plus-box mr-1"></i> Input Data Baru
                                        </span>
                                    @else
                                        <span class="text-warning">
                                            <i class="mdi mdi-pencil-box mr-1"></i> Update Data
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <label class="badge badge-success">Selesai</label>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada aktivitas terbaru.</td>
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