@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.bahan_baku.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah Bahan
        </a>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered table-hover">
                        <thead class="bg-light text-primary">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Bahan</th>
                                <th>Satuan Unit</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_bahan }}</td>
                                <td><span class="badge bg-cyan">{{ $row->satuan_unit }}</span></td>
                                <td>
                                    <a href="{{ route('backend.bahan_baku.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('backend.bahan_baku.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
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