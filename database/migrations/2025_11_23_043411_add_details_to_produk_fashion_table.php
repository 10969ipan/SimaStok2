<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk_fashion', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('id');
            $table->string('gambar')->nullable()->after('nama_produk');
            $table->enum('gender', ['Pria', 'Wanita', 'Unisex', 'Anak'])->nullable()->after('harga_jual');
            $table->string('bahan')->nullable()->after('gender');
            $table->string('musim')->nullable()->after('bahan');
            $table->string('warna')->nullable()->after('musim');
            $table->string('kode_hex_warna')->nullable()->after('warna'); // Untuk dot warna (contoh: #FF0000)
            $table->boolean('is_bestseller')->default(false)->after('kode_hex_warna');
            
            // Stok Varian Ukuran
            $table->integer('stok_xs')->default(0)->after('is_bestseller');
            $table->integer('stok_s')->default(0)->after('stok_xs');
            $table->integer('stok_m')->default(0)->after('stok_s');
            $table->integer('stok_l')->default(0)->after('stok_m');
            $table->integer('stok_xl')->default(0)->after('stok_l');
            $table->integer('stok_xxl')->default(0)->after('stok_xl');
        });
    }

    public function down(): void
    {
        Schema::table('produk_fashion', function (Blueprint $table) {
            $table->dropColumn([
                'sku', 'gambar', 'gender', 'bahan', 'musim', 'warna', 'kode_hex_warna', 'is_bestseller',
                'stok_xs', 'stok_s', 'stok_m', 'stok_l', 'stok_xl', 'stok_xxl'
            ]);
        });
    }
};