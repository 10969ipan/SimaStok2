<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        // 1. Hitung Data Real dari Database
        $total_produk    = Produk::count();
        $total_supplier  = Supplier::count();
        $total_pelanggan = Pelanggan::count();
        $total_penjualan = Penjualan::count();

        // 2. Ambil 5 Transaksi Terakhir untuk Tabel Ringkasan
        // Pastikan model Penjualan memiliki relasi 'pelanggan' dan 'user'
        $transaksi_terakhir = Penjualan::with(['pelanggan', 'user'])
                                       ->orderBy('tgl_penjualan', 'desc')
                                       ->limit(5)
                                       ->get();

        return view('backend.v_beranda.index', [
            'judul'              => 'Dashboard',
            'total_produk'       => $total_produk,
            'total_supplier'     => $total_supplier,
            'total_pelanggan'    => $total_pelanggan,
            'total_penjualan'    => $total_penjualan,
            'transaksi_terakhir' => $transaksi_terakhir
        ]);
    }
}