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
        $penjualan = Penjualan::with(['user', 'pelanggan', 'details.produk'])->orderBy('tgl_penjualan', 'desc')->get();
        return view('backend.v_penjualan.index', [
            'judul' => 'Data Penjualan',
            'index' => $penjualan
        ]);
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        
        // Ambil produk yang total stoknya (semua ukuran) lebih dari 0
        // Menggunakan whereRaw karena kita menjumlahkan kolom secara manual di query
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
            'produk_id.*' => 'exists:produk_fashion,id',
            'ukuran' => 'required|array', // Validasi ukuran wajib ada
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
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
                $ukuran = strtolower($request->ukuran[$index]); // ubah jadi huruf kecil: s, m, l
                $nama_kolom_stok = 'stok_' . $ukuran; // contoh hasil: stok_m

                $produk = ProdukFashion::findOrFail($id_produk);

                // 1. Cek apakah kolom ukuran valid (mencegah hack input ukuran aneh)
                if (!in_array($nama_kolom_stok, ['stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'])) {
                    throw new \Exception("Ukuran $ukuran tidak valid.");
                }

                // 2. Cek ketersediaan stok spesifik
                if ($produk->$nama_kolom_stok < $qty) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok ukuran ' . strtoupper($ukuran) . ' untuk ' . $produk->nama_produk . ' tidak mencukupi! (Sisa: ' . $produk->$nama_kolom_stok . ')');
                }

                // 3. Simpan Detail
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_produk' => $id_produk,
                    'ukuran' => strtoupper($ukuran), // Simpan di DB sebagai uppercase (S, M, L)
                    'kuantitas' => $qty
                ]);

                // 4. Kurangi Stok Spesifik
                $produk->decrement($nama_kolom_stok, $qty);
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
        $penjualan = Penjualan::findOrFail($id);
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