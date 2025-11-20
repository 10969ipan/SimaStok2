<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('updated_at', 'desc')->get();
        return view('backend.v_kategori.index', [
            'judul' => 'Data Kategori',
            'index' => $kategori
        ]);
    }

    public function create()
    {
        return view('backend.v_kategori.create', [
            'judul' => 'Tambah Kategori'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategori',
        ]);

        Kategori::create($validatedData);
        return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil tersimpan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('backend.v_kategori.edit', [
            'judul' => 'Ubah Kategori',
            'edit' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        
        $rules = [
            'nama_kategori' => 'required|max:255|unique:kategori,nama_kategori,' . $id,
        ];

        $validatedData = $request->validate($rules);

        $kategori->update($validatedData);
        return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil diperbaharui');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('backend.kategori.index')->with('success', 'Data berhasil dihapus');
    }
}