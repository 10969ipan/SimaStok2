@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        
        {{-- Baris Tombol Tambah & Pencarian --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('backend.produk.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Produk
            </a>

            <form action="{{ route('backend.produk.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama / SKU..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('backend.produk.index') }}" class="btn btn-danger" title="Reset Pencarian">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered table-hover">
                        <thead class="bg-light text-primary">
                            {{-- MODIFIKASI: Menambahkan class text-center --}}
                            <tr class="text-center"> 
                                <th>No</th>
                                <th>Gambar</th>
                                <th>SKU</th>
                                <th>Kategori</th>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($index as $row)
                            {{-- MODIFIKASI: Menambahkan class text-center dan align-middle --}}
                            <tr class="text-center align-middle"> 
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($row->gambar)
                                        <img src="{{ asset('storage/' . $row->gambar) }}" width="250" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('backend/image/img-default.jpg') }}" width="250" class="img-thumbnail">
                                    @endif
                                </td>
                                <td>{{ $row->sku_code ?? '-' }}</td>
                                <td>{{ $row->kategori }}</td>
                                <td>{{ $row->nama_produk }}</td>
                                
                                {{-- Style deskripsi tetap dipertahankan agar wrap text --}}
                                <td style="max-width: 300px; white-space: normal; word-break: break-word;">
                                    {{ $row->deskripsi }}
                                </td>
                               
                                
                                <td>
                                    <a href="{{ route('backend.produk.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('backend.produk.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm" onclick="return confirm('Hapus Produk ini?')" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    Data produk tidak ditemukan.
                                </td>
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