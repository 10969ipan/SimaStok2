<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukFashion extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'produk_fashion';
    protected $fillable = ['nama_produk', 'harga_jual'];
}