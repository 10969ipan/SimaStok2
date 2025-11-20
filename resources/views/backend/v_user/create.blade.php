@extends('backend.v_layouts.app')
@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-4 text-center">{{ $judul }}</h5>

        <form action="{{ route('backend.user.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
            @csrf

            <!-- Foto -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <!-- Hak Akses -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Hak Akses</label>
                <select name="role" class="form-select">
                    <option value="">- Pilih Hak Akses -</option>
                    <option value="1">Admin</option>
                    <option value="0">User</option>
                </select>
            </div>

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
            </div>

            <!-- Nomor HP -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor HP</label>
                <input type="text" name="hp" class="form-control" placeholder="Masukkan Nomor HP">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
    }
    .form-label {
        color: #495057;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px;
    }
    .btn {
        border-radius: 8px;
        padding: 8px 18px;
    }
    .card-body {
        background-color: #f9f9f9;
        border-radius: 12px;
    }
</style>
@endsection
