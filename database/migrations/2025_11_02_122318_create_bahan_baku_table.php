<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            // Menambahkan foreign key ke tabel supplier
            // Pastikan tabel 'supplier' sudah dibuat sebelum migration ini jalan
            $table->foreignId('supplier_id')->nullable()->constrained('supplier')->onDelete('set null');
            
            $table->string('nama_bahan');
            $table->string('satuan_unit');
            $table->integer('stok')->default(0); // Menambahkan kolom stok
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};