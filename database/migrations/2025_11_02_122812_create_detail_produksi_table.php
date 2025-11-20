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
         Schema::create('detail_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produksi')->constrained('produksi')->cascadeOnDelete();
            $table->foreignId('id_bahan')->constrained('bahan_baku')->cascadeOnDelete();
            $table->integer('jml_bahan_digunakan');
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_produksi');
    }
};
