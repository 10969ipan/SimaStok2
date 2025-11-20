<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksi extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'produksi';
    protected $fillable = ['id_desain', 'tgl_mulai'];

    // Relasi ke Desain Koleksi
    public function desain()
    {
        return $this->belongsTo(DesainKoleksi::class, 'id_desain');
    }
}