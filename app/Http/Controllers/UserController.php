<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Tambahan untuk hashing password jika diperlukan nanti

class UserController extends Controller
{
    // Fungsi index (Halaman Data User)
    public function index(Request $request)
    {
        $judul = 'Data User';
        $search = $request->input('search');

        $index = User::query()
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('nama', 'asc') // Mengurutkan berdasarkan nama
            ->get();

        return view('backend.v_user.index', compact('judul', 'index'));
    }

    // Fungsi create (Halaman Tambah User)
    public function create()
    {
        $judul = 'Tambah User';
        return view('backend.v_user.create', compact('judul'));
    }

    // Fungsi store (Menyimpan User Baru)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'status' => 'required',
            'hp' => 'required', // Validasi HP
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Validasi Foto
        ]);

        // Persiapan data
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'hp' => $request->hp,
        ];

        // Proses Upload Foto (Jika ada)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/user'), $fileName);
            $data['foto'] = $fileName;
        }

        User::create($data);

        return redirect()->route('backend.user.index')->with('success', 'User berhasil ditambahkan');
    }

    // Fungsi edit (Halaman Edit User)
    public function edit($id)
    {
        $judul = 'Ubah User';
        $user = User::findOrFail($id);
        return view('backend.v_user.edit', compact('judul', 'user'));
    }

    // Fungsi update (Menyimpan Perubahan User)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'status' => 'required', // Field ini wajib ada di form
            'hp' => 'required',     // Validasi HP
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Validasi Foto
        ]);

        // Data yang akan diupdate
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'hp' => $request->hp,
        ];

        // Proses Update Foto
        if ($request->hasFile('foto')) {
            // 1. Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path('uploads/user/' . $user->foto))) {
                unlink(public_path('uploads/user/' . $user->foto));
            }

            // 2. Upload foto baru
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/user'), $fileName);
            
            // 3. Masukkan nama file ke array data
            $data['foto'] = $fileName;
        }

        // Update database
        $user->update($data);

        return redirect()->route('backend.user.index')->with('success', 'User berhasil diubah');
    }

    // Fungsi destroy (Hapus User)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus file foto dari folder jika ada
        if ($user->foto && file_exists(public_path('uploads/user/' . $user->foto))) {
            unlink(public_path('uploads/user/' . $user->foto));
        }

        $user->delete();

        return redirect()->route('backend.user.index')->with('success', 'User berhasil dihapus');
    }
}