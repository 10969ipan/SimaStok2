<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku_code', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $produk = $query->orderBy('updated_at', 'desc')->get();

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
        // 1. Validasi disederhanakan (Hanya field yang ada di form)
        $validatedData = $request->validate([
            'kategori'      => 'required',
            'nama_produk'   => 'required|max:255',
            'sku_code'      => 'nullable|unique:produk,sku_code',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ]);

        // 2. Set Nilai Default untuk field yang dihapus dari form
        // (Agar tidak error di database jika kolom tersebut wajib isi)
        $validatedData['harga_beli'] = 0;
        $validatedData['harga_jual'] = 0;
        $validatedData['stok_awal']  = 0;
        $validatedData['berat']      = 0;
        $validatedData['status']     = 'Active'; // Default status aktif

        // Upload Gambar
        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('uploads/produk', 'public');
        }

        // Simpan Data
        Produk::create($validatedData);

        // Redirect ke Index
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

        // 1. Validasi disederhanakan (Hanya field yang ada di form)
        $rules = [
            'kategori'      => 'required',
            'nama_produk'   => 'required|max:255',
            'sku_code'      => 'nullable|unique:produk,sku_code,'.$id,
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi'     => 'nullable'
        ];
        
        $validatedData = $request->validate($rules);

        // Upload Gambar Baru (Jika ada)
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::exists('public/' . $produk->gambar)) {
                Storage::delete('public/' . $produk->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('uploads/produk', 'public');
        }

        // Note: Field harga/stok/berat tidak perlu di-set default disini.
        // Karena metode update() hanya akan mengubah kolom yang ada di $validatedData.
        // Nilai lama di database untuk harga/stok akan tetap aman (tidak berubah).

        $produk->update($validatedData);

        // Redirect ke Index (Menu Produk)
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