<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukFashion;

class ProdukFashionController extends Controller
{
    public function index()
    {
        $data = ProdukFashion::orderBy('updated_at', 'desc')->get();
        return view('backend.v_produk_fashion.index', [
            'judul' => 'Data Produk Fashion',
            'index' => $data
        ]);
    }

    public function create()
    {
        return view('backend.v_produk_fashion.create', ['judul' => 'Tambah Produk Fashion']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|max:255',
            'harga_jual'  => 'required|numeric',
        ]);
        
        ProdukFashion::create($validated);
        return redirect()->route('backend.produk_fashion.index')->with('success', 'Data berhasil disimpan');
    }
    
    // Method edit, update bisa ditambahkan sesuai pola sebelumnya jika diperlukan

    public function destroy($id)
    {
        ProdukFashion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}