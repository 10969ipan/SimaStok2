@extends('backend.v_layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <div>
                    <h4 class="mb-0 text-dark fw-bold">Invoice #TRX-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</h4>
                    <small class="text-muted">Diterbitkan pada: {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}</small>
                </div>
                <div>
                    <a href="{{ route('backend.penjualan.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3 font-weight-bold text-uppercase text-secondary">Informasi Pelanggan</h6>
                        <div><strong>{{ $data->pelanggan->nama_pelanggan ?? 'Umum' }}</strong></div>
                        <div>{{ $data->pelanggan->alamat ?? '-' }}</div>
                        <div>{{ $data->pelanggan->hp ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="mb-3 font-weight-bold text-uppercase text-secondary">Kasir</h6>
                        <div><strong>{{ $data->user->nama ?? 'System' }}</strong></div>
                        <div>Status: <span class="badge bg-success">LUNAS</span></div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nama Produk</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-center">Kuantitas</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->details as $item)
                            @php
                                // Mengambil harga dari tabel produk_fashion relasi
                                $harga_satuan = $item->produk->harga ?? 0;
                                $subtotal = $harga_satuan * $item->kuantitas;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ $item->produk->nama_produk ?? 'Produk Dihapus' }} <br>
                                    <small class="text-muted">{{ $item->produk->kategori->nama_kategori ?? '' }}</small>
                                </td>
                                <td class="text-end">Rp {{ number_format($harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->kuantitas }}</td>
                                <td class="text-end font-weight-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end font-weight-bold text-uppercase">Total Pembayaran</td>
                                <td class="text-end font-weight-bold text-primary" style="font-size: 18px">
                                    Rp {{ number_format($data->total_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-muted">Terima kasih telah berbelanja di SimaStok.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection