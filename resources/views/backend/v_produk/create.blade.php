@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-primary">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <form action="{{ route('backend.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="form-group mb-3">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->nama_kategori }}" {{ old('kategori') == $k->nama_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Kode SKU</label>
                                <input type="text" name="sku_code" class="form-control @error('sku_code') is-invalid @enderror" value="{{ old('sku_code') }}" placeholder="Contoh: KMJ-001">
                                @error('sku_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}">
                                @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- MENAMBAHKAN INPUT GAMBAR --}}
                            <div class="form-group mb-3">
                                <label>Gambar Produk</label>
                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection