<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        // 1. Hitung Data Real
        $total_produk    = Produk::count();
        $total_supplier  = Supplier::count();
        $total_pelanggan = Pelanggan::count();
        $total_penjualan = Penjualan::count();

        // 2. Ambil Aktivitas Terakhir
        // Tambahkan 'created_at' ke dalam select untuk logika Keterangan
        $produkTerbaru = Produk::select('nama_produk as nama', 'updated_at', 'created_at')
                                ->selectRaw("'Produk' as tipe")
                                ->latest('updated_at')
                                ->limit(5)
                                ->get();

        $bahanTerbaru = BahanBaku::select('nama_bahan as nama', 'updated_at', 'created_at')
                                ->selectRaw("'Bahan Baku' as tipe")
                                ->latest('updated_at')
                                ->limit(5)
                                ->get();

        // Gabungkan
        $aktivitas_terakhir = $produkTerbaru->concat($bahanTerbaru)
                                            ->sortByDesc('updated_at')
                                            ->take(5);

        return view('backend.v_beranda.index', [
            'judul'              => 'Dashboard',
            'total_produk'       => $total_produk,
            'total_supplier'     => $total_supplier,
            'total_pelanggan'    => $total_pelanggan,
            'total_penjualan'    => $total_penjualan,
            'aktivitas_terakhir' => $aktivitas_terakhir
        ]);
    }
}