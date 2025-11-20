<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================
        // USERS
        // ==========================
        User::create([
            'nama' => 'Irfan Arfian Kusnadi',
            'email' => 'irfan@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '19240300',
            'password' => bcrypt('adm@'),
        ]);

        User::create([
            'nama' => 'Nadarul Haebal',
            'email' => 'nadarul@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '19240785',
            'password' => bcrypt('adm@'),
        ]);

        User::create([
            'nama' => 'Naurah Sallsabila',
            'email' => 'naurah@gmail.com',
            'role' => '1',
            'status' => 1,
            'hp' => '19240432',
            'password' => bcrypt('stf@'),
        ]);

        User::create([
            'nama' => 'Ummu Habibah',
            'email' => 'ummu@gmail.com',
            'role' => '1',
            'status' => 1,
            'hp' => '19242131',
            'password' => bcrypt('stf@'),
        ]);

        User::create([
            'nama' => 'Olivia Novelina Prastika Hedi Syah Putri',
            'email' => 'olivia@gmail.com',
            'role' => '1',
            'status' => 1,
            'hp' => '19240750',
            'password' => bcrypt('stf@'),
        ]);

        // ==========================
        // PRODUK
        // ==========================
        Produk::create([
            'nama_produk'   => 'Kaos Premium Cotton',
            'sku_code'      => 'TSH-001',
            'barcode'       => '8901234567890',
            'kategori'      => 'Kaos',
            'deskripsi'     => 'Kaos berbahan cotton premium, nyaman dipakai untuk kegiatan sehari-hari.',
            'gambar'        => 'images/produk/kaos1.jpg',
            'supplier'      => 'NahKie Indonesia',
            'brand'         => 'Nahkie',
            'harga_beli'    => 75000,
            'harga_jual'    => 120000,
            'stok_awal'     => 50,
            'min_stok'      => 10,
            'lokasi_gudang' => 'Gudang A - Rak 3',
            'stok_xs'       => 5,
            'stok_s'        => 10,
            'stok_m'        => 15,
            'stok_l'        => 10,
            'stok_xl'       => 7,
            'stok_xxl'      => 3,
            'material'      => '100% Cotton',
            'warna'         => 'Putih',
            'berat'         => 250,
            'status'        => 'Active',
        ]);

        Produk::create([
            'nama_produk'   => 'Jaket Hoodie Fleece',
            'sku_code'      => 'JKT-002',
            'barcode'       => '8901234567891',
            'kategori'      => 'Jaket',
            'deskripsi'     => 'Hoodie hangat dengan bahan fleece lembut, cocok untuk cuaca dingin.',
            'gambar'        => 'images/produk/hoodie1.jpg',
            'supplier'      => 'PT Fashion Indo',
            'brand'         => 'StreetLine',
            'harga_beli'    => 150000,
            'harga_jual'    => 250000,
            'stok_awal'     => 30,
            'min_stok'      => 5,
            'lokasi_gudang' => 'Gudang B - Rak 2',
            'stok_xs'       => 2,
            'stok_s'        => 5,
            'stok_m'        => 10,
            'stok_l'        => 8,
            'stok_xl'       => 4,
            'stok_xxl'      => 1,
            'material'      => 'Fleece',
            'warna'         => 'Hitam',
            'berat'         => 600,
            'status'        => 'Active',
        ]);

        Produk::create([
            'nama_produk'   => 'Kemeja Ahdadas Formal Fit',
            'sku_code'      => 'KMJ-003',
            'barcode'       => '8901234500102',
            'kategori'      => 'Kemeja',
            'deskripsi'     => 'Kemeja rapi tapi tetap santai. Dari brand Ahdadas — bikin meeting keliatan niat.',
            'gambar'        => 'images/produk/kemeja_ahdadas.jpg',
            'supplier'      => 'PT Busana Kantoran',
            'brand'         => 'Ahdadas',
            'harga_beli'    => 95000,
            'harga_jual'    => 169000,
            'stok_awal'     => 40,
            'min_stok'      => 8,
            'lokasi_gudang' => 'Gudang A - Rak 2',
            'stok_xs'       => 2,
            'stok_s'        => 8,
            'stok_m'        => 15,
            'stok_l'        => 10,
            'stok_xl'       => 5,
            'stok_xxl'      => 0,
            'material'      => 'Katun Oxford',
            'warna'         => 'Putih',
            'berat'         => 350,
            'status'        => 'Active',
        ]);

        // ==========================
        // SUPPLIER
        // ==========================
        DB::table('supplier')->insert([
            [
                'nama_supplier' => 'CV Tekstil Abadi',
                'no_telp' => '08123456789',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_supplier' => 'UD Benang Jaya',
                'no_telp' => '08229876543',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // ==========================
        // BAHAN BAKU
        // ==========================
        DB::table('bahan_baku')->insert([
            [
                'nama_bahan' => 'Kain Katun',
                'satuan_unit' => 'meter',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_bahan' => 'Benang',
                'satuan_unit' => 'gulung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // ==========================
        // PELANGGAN
        // ==========================
        DB::table('pelanggan')->insert([
            [
                'nama_pelanggan' => 'Ani',
                'no_telp' => '089512345678',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_pelanggan' => 'Rina',
                'no_telp' => '088812312312',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // ==========================
        // PRODUK FASHION
        // ==========================
        DB::table('produk_fashion')->insert([
            [
                'nama_produk' => 'Kemeja Katun Pria',
                'harga_jual' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_produk' => 'Rok Denim Wanita',
                'harga_jual' => 275000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // ==========================
        // DESAIN KOLEKSI
        // ==========================
        DB::table('desain_koleksi')->insert([
            [
                'kategori' => 'Casual',
                'id_user' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kategori' => 'Formal',
                'id_user' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // ==========================
        // PRODUKSI
        // ==========================
        DB::table('produksi')->insert([
            [
                'id_desain' => 1,
                'tgl_mulai' => '2025-10-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_desain' => 2,
                'tgl_mulai' => '2025-10-05',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // ==========================
        // PENJUALAN
        // ==========================
        DB::table('penjualan')->insert([
            'tgl_penjualan' => '2025-10-10',
            'id_user' => 1,
            'id_pelanggan' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
