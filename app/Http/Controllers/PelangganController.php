<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('updated_at', 'desc')->get();
        return view('backend.v_pelanggan.index', [
            'judul' => 'Data Pelanggan',
            'index' => $pelanggan
        ]);
    }

    public function create()
    {
        return view('backend.v_pelanggan.create', [
            'judul' => 'Tambah Pelanggan'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|max:255',
            'no_telp'        => 'required|max:15',
        ]);

        Pelanggan::create($validatedData);
        return redirect()->route('backend.pelanggan.index')->with('success', 'Data berhasil tersimpan');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('backend.v_pelanggan.edit', [
            'judul' => 'Ubah Pelanggan',
            'edit' => $pelanggan
        ]);
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|max:255',
            'no_telp'        => 'required|max:15',
        ]);

        $pelanggan->update($validatedData);
        return redirect()->route('backend.pelanggan.index')->with('success', 'Data berhasil diperbaharui');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('backend.pelanggan.index')->with('success', 'Data berhasil dihapus');
    }
}