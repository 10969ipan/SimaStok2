<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori; // Import Model Kategori
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('updated_at', 'desc')->get();
        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'index' => $produk
        ]);
    }

    public function create()
    {
        // Ambil data kategori untuk dropdown
        $kategori = Kategori::all();
        
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori'      => 'required',
            'nama_produk'   => 'required|max:255',
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'stok_awal'     => 'required|integer',
            'berat'         => 'required|integer',
            'status'        => 'required',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ]);

        // Logika Upload Gambar
        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('uploads/produk', 'public');
        }

        Produk::create($validatedData);
        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();

        return view('backend.v_produk.edit', [
            'judul' => 'Ubah Produk',
            'edit' => $produk,
            'kategori' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $rules = [
            'kategori'      => 'required',
            'nama_produk'   => 'required|max:255',
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'stok_awal'     => 'required|integer',
            'berat'         => 'required|integer',
            'status'        => 'required',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ];

        $validatedData = $request->validate($rules);

        // Logika Update Gambar (Hapus lama, simpan baru)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
                Storage::delete('public/' . $produk->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('uploads/produk', 'public');
        }

        $produk->update($validatedData);
        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil diperbaharui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus gambar fisik saat data dihapus
        if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
            Storage::delete('public/' . $produk->gambar);
        }

        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}