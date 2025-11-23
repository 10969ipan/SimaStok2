<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_details', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel produk utama (Foreign Key)
            // 'produk_id' akan mencocokkan 'id' di tabel 'produk'
            // onDelete('cascade') artinya jika produk utama dihapus, detailnya ikut terhapus
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');

            // Info Spesifik Varian
            $table->string('sku_detail')->unique(); // SKU unik per varian (misal: KAOS-MRH-XL)
            $table->string('ukuran')->nullable();   // S, M, L, XL, 42, 43
            $table->string('warna')->nullable();    // Merah, Biru
            $table->integer('stok')->default(0);
            $table->decimal('harga_tambahan', 12, 2)->default(0); // Jika ukuran jumbo lebih mahal
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_details');
    }
};