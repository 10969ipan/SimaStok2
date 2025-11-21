<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            ->orderBy('nama', 'asc')
            ->get();

        return view('backend.v_user.index', compact('judul', 'index'));
    }

    // Form tambah user
    public function create()
    {
        $judul = 'Tambah User';
        return view('backend.v_user.create', compact('judul'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email', // Ganti users menjadi user
            'password' => 'required|min:6',
            'role' => 'required',
            'status' => 'required',
            'hp' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

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

    // Edit user
    public function edit($id)
    {
        $judul = 'Ubah User';
        $user = User::findOrFail($id);
        return view('backend.v_user.edit', compact('judul', 'user'));
    }

    // Update user
    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email,' . $id,
            'role' => 'required',
            'status' => 'required', 
            'hp' => 'required', 
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', 
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

        // PERBAIKAN: Mengarahkan ke halaman beranda utama (backend.beranda)
        return redirect()->route('backend.beranda')->with('success', 'User berhasil diubah'); //
    }

    // Hapus user
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