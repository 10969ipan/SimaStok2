@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        
        {{-- Baris Tombol Tambah & Pencarian (Sama seperti Produk) --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('backend.user.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah User
            </a>

            <form action="{{ route('backend.user.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama / Email..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    {{-- Tombol Reset (Muncul jika ada pencarian) --}}
                    @if(request('search'))
                        <a href="{{ route('backend.user.index') }}" class="btn btn-danger" title="Reset Pencarian">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="bg-light text-primary">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($index as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($row->foto)
                                        <img src="{{ asset('uploads/user/' . $row->foto) }}" width="40" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('backend/image/img-default.jpg') }}" width="40" class="rounded-circle">
                                    @endif
                                </td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->email }}</td>
                                <td>
                                    @if($row->role == 1)
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->status == 1)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.user.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('backend.user.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm" onclick="return confirm('Yakin ingin menghapus user ini?')" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Data user tidak ditemukan.
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