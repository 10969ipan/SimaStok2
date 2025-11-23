<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'penjualan';
    protected $fillable = ['tgl_penjualan', 'id_user', 'id_pelanggan'];

    // Relasi User dan Pelanggan (Sudah ada)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // TAMBAHAN: Relasi ke Detail Barang
    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }

    // TAMBAHAN: Aksesori untuk menghitung Total Bayar
    // Catatan: Asumsi model ProdukFashion memiliki kolom 'harga'
    public function getTotalBayarAttribute()
    {
        $total = 0;
        foreach ($this->details as $detail) {
            // Pastikan relasi produk dan kolom harga ada di tabel produk_fashion
            $harga = $detail->produk->harga ?? 0; 
            $total += ($harga * $detail->kuantitas);
        }
        return $total;
    }
}