<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['user', 'pelanggan'])->orderBy('tgl_penjualan', 'desc')->get();
        return view('backend.v_penjualan.index', [
            'judul' => 'Data Penjualan',
            'index' => $penjualan
        ]);
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('backend.v_penjualan.create', [
            'judul' => 'Tambah Transaksi Penjualan',
            'pelanggan' => $pelanggan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:pelanggan,id',
        ]);

        Penjualan::create([
            'tgl_penjualan' => $request->tgl_penjualan,
            'id_pelanggan' => $request->id_pelanggan,
            'id_user' => Auth::id() // Otomatis ambil user yang login
        ]);

        return redirect()->route('backend.penjualan.index')->with('success', 'Transaksi berhasil dicatat');
    }
    
    public function destroy($id)
    {
        Penjualan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}