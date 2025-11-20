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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('nama_produk');       // Product Name (VARCHAR equivalent)
            $table->string('sku_code')->nullable()->unique(); // SKU Code
            $table->string('barcode')->nullable()->unique();  // Barcode
            $table->string('kategori')->nullable(); // Category
            $table->text('deskripsi')->nullable();  // Description

            // Product Image
            $table->string('gambar')->nullable();   // Product Image path

            // Supplier Information
            $table->string('supplier')->nullable(); // Supplier name
            $table->string('brand')->nullable();    // Brand name

            // Pricing & Stock
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->integer('stok_awal')->default(0);
            $table->integer('min_stok')->default(0);
            $table->string('lokasi_gudang')->nullable();

            // Size Variants
            $table->integer('stok_xs')->default(0);
            $table->integer('stok_s')->default(0);
            $table->integer('stok_m')->default(0);
            $table->integer('stok_l')->default(0);
            $table->integer('stok_xl')->default(0);
            $table->integer('stok_xxl')->default(0);

            // Additional Details
            $table->string('material')->nullable();
            $table->string('warna')->nullable();
            $table->integer('berat')->default(0); // gram
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            // Indexes for better query performance
            $table->index('nama_produk');
            $table->index('sku_code');
            $table->index('kategori');
            $table->index('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
