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
    // Tambahkan baris ini di bagian atas file jika belum ada
// use Illuminate\Support\Facades\DB; 

    public function edit($id)
    {
        $penjualan = Penjualan::with('details')->findOrFail($id);
        $pelanggan = Pelanggan::all();
        
        // Ambil produk yang stoknya tersedia (mirip dengan create)
        $produk = ProdukFashion::whereRaw('(stok_xs + stok_s + stok_m + stok_l + stok_xl + stok_xxl) > 0')->get();

        return view('backend.v_penjualan.edit', [
            'judul' => 'Ubah Transaksi',
            'data' => $penjualan,
            'pelanggan' => $pelanggan,
            'produk' => $produk
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'produk_id' => 'required|array',
            'ukuran' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $penjualan = Penjualan::with('details')->findOrFail($id);

            // 1. KEMBALIKAN STOK LAMA (Rollback Stock)
            foreach ($penjualan->details as $detail) {
                $produkLama = ProdukFashion::find($detail->id_produk);
                if ($produkLama) {
                    $kolom_stok_lama = 'stok_' . strtolower($detail->ukuran);
                    $produkLama->increment($kolom_stok_lama, $detail->kuantitas);
                }
            }

            // 2. HAPUS DETAIL LAMA
            $penjualan->details()->delete();

            // 3. UPDATE DATA UTAMA
            $penjualan->update([
                'tgl_penjualan' => $request->tgl_penjualan,
                'id_pelanggan' => $request->id_pelanggan,
                'id_user' => Auth::id(), // Update user yang mengedit (opsional)
            ]);

            // 4. SIMPAN DETAIL BARU & KURANGI STOK BARU
            foreach ($request->produk_id as $index => $id_produk) {
                $qty = $request->jumlah[$index];
                $ukuran = strtolower($request->ukuran[$index]);
                $kolom_stok = 'stok_' . $ukuran;

                $produk = ProdukFashion::findOrFail($id_produk);

                // Cek stok baru
                if ($produk->$kolom_stok < $qty) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 
                        "Stok ukuran " . strtoupper($ukuran) . " untuk " . $produk->nama_produk . " tidak cukup! (Sisa: " . $produk->$kolom_stok . ")");
                }

                // Simpan Detail Baru
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $id_produk,
                    'ukuran' => strtoupper($ukuran),
                    'kuantitas' => $qty
                ]);

                // Kurangi Stok
                $produk->decrement($kolom_stok, $qty);
            }

            DB::commit();
            return redirect()->route('backend.penjualan.index')->with('success', 'Transaksi berhasil diperbaharui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
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