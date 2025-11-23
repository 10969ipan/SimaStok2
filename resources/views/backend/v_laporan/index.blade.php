@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    {{-- 1. KARTU LAPORAN PENJUALAN --}}
    <div class="col-md-4"> {{-- Ubah dari col-md-6 ke col-md-4 --}}
        <div class="card shadow-sm h-100">
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
                        <i class="fa fa-print"></i> Cetak
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. KARTU LAPORAN STOK PRODUK JADI --}}
    <div class="col-md-4"> {{-- Ubah dari col-md-6 ke col-md-4 --}}
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white text-info">
                <h5 class="mb-0"><i class="mdi mdi-package-variant"></i> Stok Produk Jadi</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <p>Cetak laporan seluruh stok produk jadi (pakaian) yang tersedia di gudang.</p>
                <a href="{{ route('backend.laporan.cetak_stok') }}" target="_blank" class="btn btn-info w-100 text-white mt-2">
                    <i class="fa fa-print"></i> Cetak Stok Produk
                </a>
            </div>
        </div>
    </div>

    {{-- 3. (BARU) KARTU LAPORAN STOK BAHAN BAKU --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white text-success">
                <h5 class="mb-0"><i class="mdi mdi-cube-outline"></i> Stok Bahan Baku</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <p>Cetak laporan seluruh stok bahan baku (kain, benang, dll) yang tersedia.</p>
                <a href="{{ route('backend.laporan.cetak_stok_bahan') }}" target="_blank" class="btn btn-success w-100 text-white mt-2">
                    <i class="fa fa-print"></i> Cetak Stok Bahan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection