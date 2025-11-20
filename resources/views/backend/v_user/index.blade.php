@extends('backend.v_layouts.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">{{ $judul }}</h5>
            <a href="{{ route('backend.user.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>

        <!-- 🔍 Form Search -->
        <div class="d-flex mb-3">
            <input 
                type="text" 
                id="searchInput"
                class="form-control me-2" 
                placeholder="Cari nama atau email..." 
                style="max-width: 300px;">
            <button type="button" class="btn btn-outline-primary" disabled>
                <i class="bi bi-search"></i> Cari
            </button>
        </div>

        <table class="table table-bordered table-striped align-middle text-center" id="userTable">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($index as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="nama">{{ $row->nama }}</td>
                        <td class="email">{{ $row->email }}</td>
                        <td>
                            <span class="badge bg-{{ $row->role == 1 ? 'success' : 'secondary' }}">
                                {{ $row->role == 1 ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $row->status == 1 ? 'info' : 'danger' }}">
                                {{ $row->status == 1 ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('backend.user.edit', $row->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil-square"></i> Ubah
                            </a>
                            <form action="{{ route('backend.user.destroy', $row->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ✨ SCRIPT REAL-TIME FILTER + HIGHLIGHT -->
<script>
document.getElementById("searchInput").addEventListener("input", function() {
    const search = this.value.toLowerCase();
    const rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(row => {
        const namaCell = row.querySelector(".nama");
        const emailCell = row.querySelector(".email");
        const namaText = namaCell.textContent;
        const emailText = emailCell.textContent;

        // cek apakah cocok
        const match = namaText.toLowerCase().includes(search) || emailText.toLowerCase().includes(search);

        // tampilkan/sembunyikan baris
        row.style.display = match ? "" : "none";

        // highlight kata yang cocok
        const highlight = (text) => {
            if (!search) return text;
            const regex = new RegExp(`(${search})`, "gi");
            return text.replace(regex, '<mark style="background:#fff3cd; color:#000;">$1</mark>');
        };

        namaCell.innerHTML = highlight(namaText);
        emailCell.innerHTML = highlight(emailText);
    });
});
</script>

<style>
    .card {
        border-radius: 10px;
    }
    .btn {
        border-radius: 8px;
        transition: 0.2s ease;
    }
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>
@endsection
