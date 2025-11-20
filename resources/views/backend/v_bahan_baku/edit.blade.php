@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white text-primary">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <form action="{{ route('backend.bahan_baku.update', $edit->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label>Nama Bahan</label>
                        <input type="text" name="nama_bahan" class="form-control @error('nama_bahan') is-invalid @enderror" 
                               value="{{ old('nama_bahan', $edit->nama_bahan) }}" placeholder="Masukkan Nama Bahan">
                        @error('nama_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Satuan Unit</label>
                        <select name="satuan_unit" class="form-control @error('satuan_unit') is-invalid @enderror">
                            <option value="">- Pilih Satuan -</option>
                            <option value="Meter" {{ old('satuan_unit', $edit->satuan_unit) == 'Meter' ? 'selected' : '' }}>Meter</option>
                            <option value="Yard" {{ old('satuan_unit', $edit->satuan_unit) == 'Yard' ? 'selected' : '' }}>Yard</option>
                            <option value="Gulung" {{ old('satuan_unit', $edit->satuan_unit) == 'Gulung' ? 'selected' : '' }}>Gulung</option>
                            <option value="Kg" {{ old('satuan_unit', $edit->satuan_unit) == 'Kg' ? 'selected' : '' }}>Kg</option>
                            <option value="Pcs" {{ old('satuan_unit', $edit->satuan_unit) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        </select>
                        @error('satuan_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer bg-white border-top">
                    <button type="submit" class="btn btn-primary">Perbaharui</button>
                    <a href="{{ route('backend.bahan_baku.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection