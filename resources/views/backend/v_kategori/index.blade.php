@extends('backend.v_layouts.app')
@section('content')

<div class="row">
    <div class="col-12">
        
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary m-0">{{ $judul }}</h5>
                    <a href="{{ route('backend.kategori.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered table-hover">
                        <thead class="bg-light text-primary">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kategori</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_kategori }}</td>
                                <td>
                                    <a href="{{ route('backend.kategori.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('backend.kategori.destroy', $row->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger show_confirm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
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