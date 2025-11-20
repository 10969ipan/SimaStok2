@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-primary">
                <h5 class="mb-0"><i class="mdi mdi-file-document"></i> Laporan Penjualan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.laporan.cetak_penjualan') }}" method="GET" target="_blank">
                    <div class="form-group mb-3">
                        <label>Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="{{ date('Y-m-01') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-print"></i> Cetak Laporan Penjualan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-info">
                <h5 class="mb-0"><i class="mdi mdi-package-variant"></i> Laporan Stok Produk</h5>
            </div>
            <div class="card-body">
                <p>Cetak laporan seluruh stok produk yang tersedia di gudang saat ini.</p>
                <br>
                <a href="{{ route('backend.laporan.cetak_stok') }}" target="_blank" class="btn btn-info w-100 text-white mt-2">
                    <i class="fa fa-print"></i> Cetak Laporan Stok
                </a>
            </div>
        </div>
    </div>
</div>

@endsection