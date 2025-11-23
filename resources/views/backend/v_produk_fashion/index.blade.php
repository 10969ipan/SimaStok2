@extends('backend.v_layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.produk_fashion.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah Produk
        </a>
        
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover align-middle">
                        <thead class="bg-light text-primary">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>SKU / Info</th>
                                <th>Harga</th>
                                <th>Rincian Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($row->gambar)
                                            <img src="{{ asset('storage/'.$row->gambar) }}" class="rounded border me-2" width="200" height="200" style="object-fit: cover;">
                                        @else
                                            <img src="{{ asset('backend/image/img-default.jpg') }}" class="rounded border me-2" width="200" height="200" style="object-fit: cover;">
                                        @endif
                                        <div>
                                            <span class="fw-bold text-dark">{{ $row->nama_produk }}</span><br>
                                            <small class="text-muted">{{ $row->bahan ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="fw-bold">{{ $row->sku ?? '-' }}</small><br>
                                    <span class="badge bg-info text-dark">{{ $row->gender }}</span>
                                    <span class="badge bg-light text-dark border">{{ $row->warna }}</span>
                                </td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($row->harga_jual, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        <span class="badge bg-light text-dark border">S: {{ $row->stok_s }}</span>
                                        <span class="badge bg-light text-dark border">M: {{ $row->stok_m }}</span>
                                        <span class="badge bg-light text-dark border">L: {{ $row->stok_l }}</span>
                                        <span class="badge bg-light text-dark border">XL: {{ $row->stok_xl }}</span>
                                    </div>
                                    <small class="text-muted">Total: <b>{{ $row->total_stok }}</b> pcs</small>
                                </td>
                                <td>
                                    @if($row->total_stok > 0)
                                        <span class="badge bg-success">Ready</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('backend.produk_fashion.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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