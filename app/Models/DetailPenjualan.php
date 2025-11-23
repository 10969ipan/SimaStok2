<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_penjualan';
    protected $guarded = ['id'];

    // Relasi ke tabel Produk Fashion (sesuai migration Anda yang mereference produk_fashion)
    public function produk()
    {
        return $this->belongsTo(ProdukFashion::class, 'id_produk');
    }

    // Relasi ke Penjualan Utama
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }
}