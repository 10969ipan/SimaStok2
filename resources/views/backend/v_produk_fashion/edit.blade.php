@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header text-primary bg-white">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <form action="{{ route('backend.produk_fashion.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $edit->nama_produk) }}">
                                @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>SKU</label>
                                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $edit->sku) }}" placeholder="Contoh: KMJ-001">
                                        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Harga Jual (Rp)</label>
                                        <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror" value="{{ old('harga_jual', $edit->harga_jual) }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Gender / Kategori</label>
                                        <select name="gender" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="Pria" {{ old('gender', $edit->gender) == 'Pria' ? 'selected' : '' }}>Pria</option>
                                            <option value="Wanita" {{ old('gender', $edit->gender) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                            <option value="Unisex" {{ old('gender', $edit->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                            <option value="Anak" {{ old('gender', $edit->gender) == 'Anak' ? 'selected' : '' }}>Anak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Warna Utama</label>
                                        <input type="text" name="warna" class="form-control" value="{{ old('warna', $edit->warna) }}" placeholder="Merah, Navy, dll">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label>Gambar Produk</label>
                                @if($edit->gambar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$edit->gambar) }}" alt="Foto Produk" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary mb-2">Stok Varian Ukuran</label>
                            <div class="p-3 bg-light rounded border">
                                <div class="row">
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
                                    <div class="col-4 mb-2">
                                        <label><small>L</small></label>
                                        <input type="number" name="stok_l" class="form-control form-control-sm" value="{{ old('stok_l', $edit->stok_l) }}">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>XL</small></label>
                                        <input type="number" name="stok_xl" class="form-control form-control-sm" value="{{ old('stok_xl', $edit->stok_xl) }}">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>XXL</small></label>
                                        <input type="number" name="stok_xxl" class="form-control form-control-sm" value="{{ old('stok_xxl', $edit->stok_xxl) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Bahan / Material</label>
                                <input type="text" name="bahan" class="form-control" value="{{ old('bahan', $edit->bahan) }}" placeholder="Contoh: Cotton Combed 30s">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('backend.produk_fashion.index') }}" class="btn btn-secondary">Kembali</a>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection