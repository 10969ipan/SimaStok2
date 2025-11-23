<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\ProdukFashion; // Pastikan Model ini sesuai dengan file Anda
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        // Mengambil data penjualan beserta relasinya untuk ditampilkan di tabel utama
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
        // Hanya ambil produk yang stoknya tersedia (> 0)
        $produk = ProdukFashion::where('stok', '>', 0)->get();
        
        return view('backend.v_penjualan.create', [
            'judul' => 'Tambah Transaksi',
            'pelanggan' => $pelanggan,
            'produk' => $produk
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'produk_id' => 'required|array', // Harus array karena banyak barang
            'produk_id.*' => 'exists:produk_fashion,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        try {
            DB::beginTransaction(); // Mulai Transaksi Database

            // 2. Simpan Header Penjualan (Satu kali)
            $penjualan = Penjualan::create([
                'tgl_penjualan' => $request->tgl_penjualan,
                'id_pelanggan' => $request->id_pelanggan,
                'id_user' => Auth::id(), // Mengambil ID user yang sedang login
            ]);

            // 3. Simpan Detail Barang & Update Stok (Looping)
            foreach ($request->produk_id as $index => $id_produk) {
                $qty = $request->jumlah[$index];
                
                // Cek stok terakhir sebelum simpan
                $produk = ProdukFashion::findOrFail($id_produk);
                if ($produk->stok < $qty) {
                    // Jika stok kurang, batalkan semua proses
                    DB::rollBack(); 
                    return redirect()->back()->with('error', 'Stok untuk produk ' . $produk->nama_produk . ' tidak mencukupi!');
                }

                // Simpan ke detail_penjualan
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $id_produk,
                    'kuantitas' => $qty
                ]);

                // Kurangi Stok Produk
                $produk->decrement('stok', $qty);
            }

            DB::commit(); // Simpan permanen jika sukses
            return redirect()->route('backend.penjualan.index')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        // Opsional: Kembalikan stok jika transaksi dihapus
        /* foreach ($penjualan->details as $detail) {
            $detail->produk->increment('stok', $detail->kuantitas);
        } 
        */
        $penjualan->delete();
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