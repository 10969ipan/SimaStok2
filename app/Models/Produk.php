<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // 👈 tambahkan ini

    protected $fillable = [
        'nama_produk',
        'sku_code',
        'barcode',
        'kategori',
        'deskripsi',
        'gambar',
        'supplier',
        'brand',
        'harga_beli',
        'harga_jual',
        'stok_awal',
        'min_stok',
        'lokasi_gudang',
        'stok_xs',
        'stok_s',
        'stok_m',
        'stok_l',
        'stok_xl',
        'stok_xxl',
        'material',
        'warna',
        'berat',
        'status',
    ];
}
