<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukFashion extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'produk_fashion';
    
    protected $fillable = [
        'sku',
        'nama_produk',
        'gambar',
        'harga_jual',
        'gender',
        'bahan',
        'musim',
        'warna',
        'kode_hex_warna',
        'is_bestseller',
        'stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'
    ];

    // Aksesori untuk menghitung total stok dinamis
    public function getTotalStokAttribute()
    {
        return $this->stok_xs + $this->stok_s + $this->stok_m + 
               $this->stok_l + $this->stok_xl + $this->stok_xxl;
    }
}