@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-primary">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <form action="{{ route('backend.produk.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->nama_kategori }}" {{ old('kategori', $edit->kategori) == $k->nama_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Kode SKU</label>
                                <input type="text" name="sku_code" class="form-control @error('sku_code') is-invalid @enderror" value="{{ old('sku_code', $edit->sku_code) }}">
                                @error('sku_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $edit->nama_produk) }}">
                                @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Harga Beli (Rp)</label>
                                        <input type="number" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror" value="{{ old('harga_beli', $edit->harga_beli) }}">
                                        @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Harga Jual (Rp)</label>
                                        <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror" value="{{ old('harga_jual', $edit->harga_jual) }}">
                                        @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Input Stok Per Ukuran --}}
                            <label class="mb-1 font-weight-bold text-primary">Stok Varian Ukuran</label>
                            <div class="row mb-3 p-2 border rounded bg-light">
                                <div class="col-4 mb-2">
                                    <label><small>XS</small></label>
                                    <input type="number" name="stok_xs" class="form-control form-control-sm" value="{{ old('stok_xs', $edit->stok_xs) }}">
                                </div>
                                <div class="col-4 mb-2">
                                    <label><small>S</small></label>
                                    <input type="number" name="stok_s" class="form-control form-control-sm" value="{{ old('stok_s', $edit->stok_s) }}">
                                </div>
                                <div class="col-4 mb-2">
                                    <label><small>M</small></label>
                                    <input type="number" name="stok_m" class="form-control form-control-sm" value="{{ old('stok_m', $edit->stok_m) }}">
                                </div>
                                <div class="col-4">
                                    <label><small>L</small></label>
                                    <input type="number" name="stok_l" class="form-control form-control-sm" value="{{ old('stok_l', $edit->stok_l) }}">
                                </div>
                                <div class="col-4">
                                    <label><small>XL</small></label>
                                    <input type="number" name="stok_xl" class="form-control form-control-sm" value="{{ old('stok_xl', $edit->stok_xl) }}">
                                </div>
                                <div class="col-4">
                                    <label><small>XXL</small></label>
                                    <input type="number" name="stok_xxl" class="form-control form-control-sm" value="{{ old('stok_xxl', $edit->stok_xxl) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Stok Total / Awal</label>
                                        <input type="number" name="stok_awal" class="form-control @error('stok_awal') is-invalid @enderror" value="{{ old('stok_awal', $edit->stok_awal) }}">
                                        @error('stok_awal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Berat (Gram)</label>
                                        <input type="number" name="berat" class="form-control @error('berat') is-invalid @enderror" value="{{ old('berat', $edit->berat) }}">
                                        @error('berat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="Active" {{ old('status', $edit->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $edit->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Ganti Gambar (Opsional)</label>
                                @if($edit->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$edit->gambar) }}" width="80" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button type="submit" class="btn btn-primary">Perbaharui</button>
                    <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection