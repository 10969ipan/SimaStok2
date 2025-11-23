@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header text-primary bg-white">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <form action="{{ route('backend.produk_fashion.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}">
                                @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>SKU</label>
                                        <input type="text" name="sku" class="form-control" placeholder="Contoh: KMJ-001">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Harga Jual (Rp)</label>
                                        <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Gender / Kategori</label>
                                        <select name="gender" class="form-control">
                                            <option value="">- Pilih -</option>
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                            <option value="Unisex">Unisex</option>
                                            <option value="Anak">Anak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Warna Utama</label>
                                        <input type="text" name="warna" class="form-control" placeholder="Merah, Navy, dll">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label>Gambar Produk</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-primary mb-2">Stok Varian Ukuran</label>
                            <div class="p-3 bg-light rounded border">
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <label><small>XS</small></label>
                                        <input type="number" name="stok_xs" class="form-control form-control-sm" value="0">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>S</small></label>
                                        <input type="number" name="stok_s" class="form-control form-control-sm" value="0">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>M</small></label>
                                        <input type="number" name="stok_m" class="form-control form-control-sm" value="0">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>L</small></label>
                                        <input type="number" name="stok_l" class="form-control form-control-sm" value="0">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>XL</small></label>
                                        <input type="number" name="stok_xl" class="form-control form-control-sm" value="0">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label><small>XXL</small></label>
                                        <input type="number" name="stok_xxl" class="form-control form-control-sm" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Bahan / Material</label>
                                <input type="text" name="bahan" class="form-control" placeholder="Contoh: Cotton Combed 30s">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <a href="{{ route('backend.produk_fashion.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection