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
        Schema::create('pembelian_bahan', function (Blueprint $table) {
            $table->id(); // 🟢 wajib ada, ini jadi primary key utama
            $table->foreignId('id_supplier')->constrained('supplier')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('user')->cascadeOnDelete();
            $table->date('tanggal_pembelian');
            $table->decimal('total_harga', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bahan');
    }
};
