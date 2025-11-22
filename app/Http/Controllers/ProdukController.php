<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
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
            'sku_code'      => 'nullable|unique:produk,sku_code', // Tambahan SKU
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'stok_awal'     => 'required|integer',
            'stok_xs'       => 'nullable|integer', // Tambahan Size
            'stok_s'        => 'nullable|integer',
            'stok_m'        => 'nullable|integer',
            'stok_l'        => 'nullable|integer',
            'stok_xl'       => 'nullable|integer',
            'stok_xxl'      => 'nullable|integer',
            'berat'         => 'required|integer',
            'status'        => 'required',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ]);

        // Set default 0 jika null untuk stok ukuran
        $ukuran = ['stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'];
        foreach ($ukuran as $uk) {
            if (!isset($validatedData[$uk])) $validatedData[$uk] = 0;
        }

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
            'sku_code'      => 'nullable|unique:produk,sku_code,'.$id, // Ignore unique for current ID
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'stok_awal'     => 'required|integer',
            'stok_xs'       => 'nullable|integer',
            'stok_s'        => 'nullable|integer',
            'stok_m'        => 'nullable|integer',
            'stok_l'        => 'nullable|integer',
            'stok_xl'       => 'nullable|integer',
            'stok_xxl'      => 'nullable|integer',
            'berat'         => 'required|integer',
            'status'        => 'required',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ];

        $validatedData = $request->validate($rules);

         // Set default 0 jika null
         $ukuran = ['stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'];
         foreach ($ukuran as $uk) {
             if (!isset($validatedData[$uk])) $validatedData[$uk] = 0;
         }

        if ($request->hasFile('gambar')) {
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
        if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
            Storage::delete('public/' . $produk->gambar);
        }
        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}