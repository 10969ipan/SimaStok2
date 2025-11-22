<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // Modifikasi method index untuk menangani pencarian
    public function index(Request $request)
    {
        $query = Produk::query();

        // Cek apakah ada parameter pencarian dikirim
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku_code', 'like', '%' . $search . '%') // Pastikan kolom sku_code ada di DB
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $produk = $query->orderBy('updated_at', 'desc')->get();

        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'index' => $produk
        ]);
    }

    // ... method create, store, edit, update, destroy tetap sama ...
    // (Pastikan method lainnya tetap ada seperti kode Anda sebelumnya)
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
        // ... kode store Anda ...
        $validatedData = $request->validate([
            'kategori'      => 'required',
            'nama_produk'   => 'required|max:255',
            // Pastikan validasi sku_code ada jika Anda sudah menambahkannya
            'sku_code'      => 'nullable|unique:produk,sku_code',
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'stok_awal'     => 'required|integer',
            'berat'         => 'required|integer',
            'status'        => 'required',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ]);

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
        // ... kode update Anda ...
        $produk = Produk::findOrFail($id);
        $rules = [
            'kategori'      => 'required',
            'nama_produk'   => 'required|max:255',
            'sku_code'      => 'nullable|unique:produk,sku_code,'.$id,
            'harga_beli'    => 'required|numeric',
            'harga_jual'    => 'required|numeric',
            'stok_awal'     => 'required|integer',
            'berat'         => 'required|integer',
            'status'        => 'required',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ];
        
        $validatedData = $request->validate($rules);

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
        // ... kode destroy Anda ...
        $produk = Produk::findOrFail($id);
        if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
            Storage::delete('public/' . $produk->gambar);
        }
        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil dihapus');
    }
}