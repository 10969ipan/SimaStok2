<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bahan_baku';
    
    // Tambahkan supplier_id dan stok ke fillable
    protected $fillable = [
        'supplier_id', 
        'nama_bahan', 
        'satuan_unit', 
        'stok'
    ];

    // Relasi ke tabel Supplier
    public function supplier()
    {
        // belongsTo(ModelTarget, foreign_key)
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}