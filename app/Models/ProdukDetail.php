<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukDetail extends Model
{
    use HasFactory;

    protected $table = 'produk_details';

    protected $fillable = [
        'produk_id',
        'sku_detail',
        'ukuran',
        'warna',
        'stok',
        'harga_tambahan'
    ];

    // Relasi Balik: Detail ini milik satu Produk Utama
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}