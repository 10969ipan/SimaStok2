<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\ProdukFashion;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['user', 'pelanggan', 'details.produk'])
            ->orderBy('tgl_penjualan', 'desc')
            ->get();
            
        return view('backend.v_penjualan.index', [
            'judul' => 'Data Penjualan',
            'index' => $penjualan
        ]);
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        
        // PERBAIKAN: Ambil produk yang total semua varian stoknya > 0
        // Kita gunakan whereRaw untuk menjumlahkan kolom stok varian
        $produk = ProdukFashion::whereRaw('(stok_xs + stok_s + stok_m + stok_l + stok_xl + stok_xxl) > 0')->get();
        
        return view('backend.v_penjualan.create', [
            'judul' => 'Tambah Transaksi',
            'pelanggan' => $pelanggan,
            'produk' => $produk
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'produk_id' => 'required|array',
            'ukuran' => 'required|array', // Wajib pilih ukuran
            'jumlah' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $penjualan = Penjualan::create([
                'tgl_penjualan' => $request->tgl_penjualan,
                'id_pelanggan' => $request->id_pelanggan,
                'id_user' => Auth::id(),
            ]);

            foreach ($request->produk_id as $index => $id_produk) {
                $qty = $request->jumlah[$index];
                $ukuran = strtolower($request->ukuran[$index]); // s, m, l
                $kolom_stok = 'stok_' . $ukuran; // misal: stok_m

                $produk = ProdukFashion::findOrFail($id_produk);

                // Cek apakah stok varian tersebut mencukupi
                if ($produk->$kolom_stok < $qty) {
                    DB::rollBack(); // Batalkan semua jika stok kurang
                    return redirect()->back()->with('error', 
                        "Stok ukuran " . strtoupper($ukuran) . " untuk " . $produk->nama_produk . " tidak cukup! (Sisa: " . $produk->$kolom_stok . ")");
                }

                // Simpan Detail
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $id_produk,
                    'ukuran' => strtoupper($ukuran),
                    'kuantitas' => $qty
                ]);

                // Kurangi Stok Varian Spesifik
                $produk->decrement($kolom_stok, $qty);
            }

            DB::commit();
            return redirect()->route('backend.penjualan.index')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        Penjualan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'pelanggan', 'details.produk'])->findOrFail($id);
        return view('backend.v_penjualan.show', [
            'judul' => 'Detail Transaksi',
            'data' => $penjualan
        ]);
    }
}