@extends('backend.v_layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary font-weight-bold">{{ $judul }}</h5>
                <a href="{{ route('backend.penjualan.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Transaksi Baru
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered table-hover w-100">
                        <thead class="bg-light text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal & ID</th>
                                <th>Pelanggan</th>
                                <th>Total Transaksi</th>
                                <th>Kasir</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($row->tgl_penjualan)->format('d M Y') }}</span><br>
                                    <small class="text-muted">#TRX-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>{{ $row->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                                <td>
                                    {{-- Menggunakan accessor getTotalBayarAttribute --}}
                                    <span class="badge bg-success p-2" style="font-size: 14px">
                                        Rp {{ number_format($row->total_bayar, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td><i class="fa fa-user-circle text-muted"></i> {{ $row->user->nama ?? 'System' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        {{-- Tombol Detail / Invoice --}}
                                        <a href="{{ route('backend.penjualan.show', $row->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        
                                        {{-- TAMBAHAN: Tombol Edit --}}
                                        <a href="{{ route('backend.penjualan.edit', $row->id) }}" class="btn btn-sm btn-primary text-white" title="Edit Transaksi">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        {{-- Tombol Cetak (Opsional) --}}
                                        <a href="#" class="btn btn-sm btn-warning text-white" title="Cetak Struk">
                                            <i class="fa fa-print"></i>
                                        </a>

                                        <form action="{{ route('backend.penjualan.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection