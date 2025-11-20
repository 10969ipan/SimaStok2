<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\DesainKoleksi;

class ProduksiController extends Controller
{
    public function index()
    {
        $data = Produksi::with('desain.user')->orderBy('tgl_mulai', 'desc')->get();
        return view('backend.v_produksi.index', [
            'judul' => 'Data Produksi',
            'index' => $data
        ]);
    }

    public function create()
    {
        $desain = DesainKoleksi::with('user')->get();
        return view('backend.v_produksi.create', [
            'judul' => 'Tambah Jadwal Produksi',
            'desain' => $desain
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_desain' => 'required|exists:desain_koleksi,id',
            'tgl_mulai' => 'required|date',
        ]);
        
        Produksi::create($validated);
        return redirect()->route('backend.produksi.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        Produksi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}