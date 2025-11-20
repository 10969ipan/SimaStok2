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
        // BAHAN BAKU
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan');
            $table->string('satuan_unit');
            $table->timestamps();
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};
