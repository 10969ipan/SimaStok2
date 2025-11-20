<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;

class LaporanController extends Controller
{
    // Halaman Utama Laporan (Menu Pilihan)
    public function index()
    {
        return view('backend.v_laporan.index', [
            'judul' => 'Laporan Toko'
        ]);
    }

    // Cetak Laporan Penjualan
    public function cetakPenjualan(Request $request)
    {
        $request->validate([
            'tgl_awal'  => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
        ]);

        $tgl_awal  = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        // Ambil data penjualan sesuai range tanggal
        $data = Penjualan::with(['user', 'pelanggan'])
                ->whereBetween('tgl_penjualan', [$tgl_awal, $tgl_akhir])
                ->get();

        return view('backend.v_laporan.cetak_penjualan', [
            'judul'     => 'Laporan Penjualan',
            'tgl_awal'  => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'data'      => $data
        ]);
    }

    // Cetak Laporan Stok Produk
    public function cetakStok()
    {
        // Ambil semua produk, urutkan stok dari yang terkecil (untuk warning)
        $data = Produk::orderBy('stok_awal', 'asc')->get();

        return view('backend.v_laporan.cetak_stok', [
            'judul' => 'Laporan Stok Produk',
            'data'  => $data
        ]);
    }
}