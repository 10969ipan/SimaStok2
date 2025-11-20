<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ Fungsi index yang baru (dengan search)
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'status' => 'required',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'status' => 'required',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.user.index')->with('success', 'User berhasil diubah');
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('backend.user.index')->with('success', 'User berhasil dihapus');
    }
}
