<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukFashionController;
use App\Http\Controllers\DesainKoleksiController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Halaman beranda backend (butuh login)
Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])
    ->middleware('auth')
    ->name('backend.beranda');

// Halaman login (GET)
Route::get('backend/login', [LoginController::class, 'loginBackend'])
    ->name('backend.login');

// Proses login (POST)
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])
    ->name('backend.login.process');

// Logout (POST)
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])
    ->name('backend.logout');

// CRUD User (Resource Controller)
Route::resource('backend/user', UserController::class, ['as' => 'backend']);

Route::resource('/backend/kategori', KategoriController::class, ['as' => 'backend']);

Route::middleware('auth')->group(function () {
    // ... route user & kategori

    // Route Produk
Route::resource('/backend/produk', ProdukController::class, ['as' => 'backend']);
Route::middleware('auth')->group(function () {
    // ... route sebelumnya (beranda, user, produk, kategori) ...

    // Route Master Data Tambahan
Route::resource('/backend/supplier', SupplierController::class, ['as' => 'backend']);
    // Route::resource('/backend/bahan_baku', BahanBakuController::class, ['as' => 'backend']);
    // Route::resource('/backend/pelanggan', PelangganController::class, ['as' => 'backend']);
    
    // Route Transaksi
Route::resource('/backend/penjualan', PenjualanController::class, ['as' => 'backend']);
Route::resource('/backend/produk_fashion', ProdukFashionController::class, ['as' => 'backend']);

// Desain Koleksi
Route::resource('/backend/desain_koleksi', DesainKoleksiController::class, ['as' => 'backend']);

// Produksi
Route::resource('/backend/produksi', ProduksiController::class, ['as' => 'backend']);
Route::resource('/backend/pelanggan', PelangganController::class, ['as' => 'backend']);
Route::resource('/backend/bahan_baku', BahanBakuController::class, ['as' => 'backend']);
Route::get('/backend/laporan', [LaporanController::class, 'index'])->name('backend.laporan.index');
Route::get('/backend/laporan/cetak-penjualan', [LaporanController::class, 'cetakPenjualan'])->name('backend.laporan.cetak_penjualan');
Route::get('/backend/laporan/cetak-stok', [LaporanController::class, 'cetakStok'])->name('backend.laporan.cetak_stok');
Route::get('/backend/laporan/cetak-stok-bahan', [LaporanController::class, 'cetakStokBahan'])->name('backend.laporan.cetak_stok_bahan');
// Tambahkan di dalam group route backend/penjualan
Route::get('penjualan/{id}', [PenjualanController::class, 'show'])->name('backend.penjualan.show');
});
});