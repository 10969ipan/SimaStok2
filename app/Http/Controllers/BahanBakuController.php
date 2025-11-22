<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Supplier; // Pastikan Import Model Supplier

class BahanBakuController extends Controller
{
    public function index()
    {
        // Load relasi supplier untuk menghindari N+1 Query problem
        $bahan = BahanBaku::with('supplier')->orderBy('updated_at', 'desc')->get();
        return view('backend.v_bahan_baku.index', [
            'judul' => 'Data Bahan Baku',
            'index' => $bahan
        ]);
    }

    public function create()
    {
        // Ambil data supplier untuk dropdown
        $supplier = Supplier::orderBy('nama_supplier', 'asc')->get();
        
        return view('backend.v_bahan_baku.create', [
            'judul' => 'Tambah Bahan Baku',
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:supplier,id', // Validasi supplier harus ada
            'nama_bahan'  => 'required|max:255|unique:bahan_baku',
            'satuan_unit' => 'required|max:50',
            'stok'        => 'required|integer|min:0', // Validasi stok
        ]);

        BahanBaku::create($validatedData);
        return redirect()->route('backend.bahan_baku.index')->with('success', 'Data berhasil tersimpan');
    }

    public function edit($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $supplier = Supplier::orderBy('nama_supplier', 'asc')->get(); // Ambil data supplier
        
        return view('backend.v_bahan_baku.edit', [
            'judul' => 'Ubah Bahan Baku',
            'edit' => $bahan,
            'supplier' => $supplier
        ]);
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'nama_bahan'  => 'required|max:255|unique:bahan_baku,nama_bahan,' . $id,
            'satuan_unit' => 'required|max:50',
            'stok'        => 'required|integer|min:0',
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