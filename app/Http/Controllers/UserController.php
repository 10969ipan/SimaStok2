<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Fungsi index (Halaman Data User dengan Pencarian)
    public function index(Request $request)
    {
        $judul = 'Data User';
        $query = User::query();

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('hp', 'like', "%{$search}%"); // Opsional: cari by No HP juga
            });
        }

        // Urutkan data (bisa berdasarkan nama atau updated_at)
        $index = $query->orderBy('updated_at', 'desc')->get();

        return view('backend.v_user.index', [
            'judul' => $judul,
            'index' => $index
        ]);
    }

    // ... (Biarkan method create, store, edit, destroy tetap seperti sebelumnya) ...

    // NOTE: Perbaiki method update Anda yang redirect ke beranda
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

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'hp' => $request->hp, 
        ];

        if ($request->hasFile('foto')) {
            if ($user->foto && file_exists(public_path('uploads/user/' . $user->foto))) {
                unlink(public_path('uploads/user/' . $user->foto));
            }
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/user'), $fileName);
            $data['foto'] = $fileName;
        }

        $user->update($data);

        // Ubah redirect kembali ke index user, bukan beranda
        return redirect()->route('backend.user.index')->with('success', 'User berhasil diperbaharui');
    }
    
    // ... (Method destroy tetap sama) ...
    public function create()
    {
        $judul = 'Tambah User';
        return view('backend.v_user.create', compact('judul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email',
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

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/user'), $fileName);
            $data['foto'] = $fileName;
        }

        User::create($data);

        return redirect()->route('backend.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $judul = 'Ubah User';
        $user = User::findOrFail($id);
        return view('backend.v_user.edit', compact('judul', 'user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->foto && file_exists(public_path('uploads/user/' . $user->foto))) {
            unlink(public_path('uploads/user/' . $user->foto));
        }

        $user->delete();

        return redirect()->route('backend.user.index')->with('success', 'User berhasil dihapus');
    }
}