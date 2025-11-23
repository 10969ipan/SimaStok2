<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukFashion;
use Illuminate\Support\Facades\Storage;

class ProdukFashionController extends Controller
{
    public function index()
    {
        $data = ProdukFashion::orderBy('updated_at', 'desc')->get();
        return view('backend.v_produk_fashion.index', [
            'judul' => 'Data Detail Produk',
            'index' => $data
        ]);
    }

    public function create()
    {
        return view('backend.v_produk_fashion.create', ['judul' => 'Tambah Detail Produk']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|max:255',
            'sku'         => 'nullable|unique:produk_fashion,sku',
            'harga_jual'  => 'required|numeric',
            'gender'      => 'nullable',
            'bahan'       => 'nullable',
            'warna'       => 'nullable',
            'stok_xs'     => 'nullable|integer',
            'stok_s'      => 'nullable|integer',
            'stok_m'      => 'nullable|integer',
            'stok_l'      => 'nullable|integer',
            'stok_xl'     => 'nullable|integer',
            'stok_xxl'    => 'nullable|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Default nilai 0 untuk stok jika kosong
        $sizes = ['stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'];
        foreach ($sizes as $size) {
            $validated[$size] = $request->input($size, 0);
        }

        // Upload Gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('uploads/fashion', 'public');
        }

        ProdukFashion::create($validated);
        return redirect()->route('backend.produk_fashion.index')->with('success', 'Data berhasil disimpan');
    }
    public function edit($id)
    {
        $data = ProdukFashion::findOrFail($id);
        return view('backend.v_produk_fashion.edit', [
            'judul' => 'Ubah Detail Produk',
            'edit' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = ProdukFashion::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|max:255',
            // Perhatikan penambahan .$id untuk mengecualikan SKU milik produk ini sendiri saat validasi unique
            'sku'         => 'nullable|unique:produk_fashion,sku,' . $id,
            'harga_jual'  => 'required|numeric',
            'gender'      => 'nullable',
            'bahan'       => 'nullable',
            'warna'       => 'nullable',
            'stok_xs'     => 'nullable|integer',
            'stok_s'      => 'nullable|integer',
            'stok_m'      => 'nullable|integer',
            'stok_l'      => 'nullable|integer',
            'stok_xl'     => 'nullable|integer',
            'stok_xxl'    => 'nullable|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Default nilai 0 untuk stok jika kosong
        $sizes = ['stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'];
        foreach ($sizes as $size) {
            $validated[$size] = $request->input($size, 0);
        }

        // Upload Gambar Baru (Jika ada)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
                Storage::delete('public/' . $produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('uploads/fashion', 'public');
        }

        $produk->update($validated);
        return redirect()->route('backend.produk_fashion.index')->with('success', 'Data berhasil diperbarui');
    }
    public function destroy($id)
    {
        $produk = ProdukFashion::findOrFail($id);
        
        // Hapus gambar fisik jika ada
        if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
            Storage::delete('public/' . $produk->gambar);
        }
        
        $produk->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}