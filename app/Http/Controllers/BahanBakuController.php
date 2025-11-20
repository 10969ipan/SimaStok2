<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahan = BahanBaku::orderBy('updated_at', 'desc')->get();
        return view('backend.v_bahan_baku.index', [
            'judul' => 'Data Bahan Baku',
            'index' => $bahan
        ]);
    }

    public function create()
    {
        return view('backend.v_bahan_baku.create', [
            'judul' => 'Tambah Bahan Baku'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_bahan'  => 'required|max:255|unique:bahan_baku',
            'satuan_unit' => 'required|max:50',
        ]);

        BahanBaku::create($validatedData);
        return redirect()->route('backend.bahan_baku.index')->with('success', 'Data berhasil tersimpan');
    }

    public function edit($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        return view('backend.v_bahan_baku.edit', [
            'judul' => 'Ubah Bahan Baku',
            'edit' => $bahan
        ]);
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $validatedData = $request->validate([
            'nama_bahan'  => 'required|max:255|unique:bahan_baku,nama_bahan,' . $id,
            'satuan_unit' => 'required|max:50',
        ]);

        $bahan->update($validatedData);
        return redirect()->route('backend.bahan_baku.index')->with('success', 'Data berhasil diperbaharui');
    }

    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->delete();
        return redirect()->route('backend.bahan_baku.index')->with('success', 'Data berhasil dihapus');
    }
}