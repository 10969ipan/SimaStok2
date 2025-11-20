@extends('backend.v_layouts.app')
@section('content')
<!-- contentAwal -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>{{ $judul }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Foto -->
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        @if($user->foto)
                            <img src="{{ asset('uploads/user/' . $user->foto) }}" class="img-thumbnail mb-2" style="max-width: 150px;">
                        @endif
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hak Akses -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Hak Akses</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Super Admin</option>
                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- HP -->
                    <div class="mb-3">
                        <label for="hp" class="form-label">Nomor HP</label>
                        <input type="text" name="hp" id="hp" value="{{ old('hp', $user->hp) }}" class="form-control @error('hp') is-invalid @enderror" onkeypress="return hanyaAngka(event)">
                        @error('hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection

@section('scripts')
<script>
    // hanya angka
    function hanyaAngka(event) {
        const charCode = event.which ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
@endsection
