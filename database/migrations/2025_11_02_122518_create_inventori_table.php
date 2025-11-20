<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bahan')->nullable()->constrained('bahan_baku')->nullOnDelete();
            $table->foreignId('id_produk')->nullable()->constrained('produk_fashion')->nullOnDelete();
            $table->string('nama_barang');
            $table->string('kategori');
            $table->integer('stok_saat_ini')->default(0);
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventori');
    }
};
