<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_barang')->truncate(); // opsional, kalau kamu ingin data lama dihapus
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1, // ELEKTRONIK
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Smartphone Samsung A14',
                'harga_beli' => 2500000,
                'harga_jual' => 2800000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 2, // PAKAIAN
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Kaos Polo Pria',
                'harga_beli' => 60000,
                'harga_jual' => 85000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 3, // MAKANAN
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Snack Kentang BBQ 200gr',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 4, // MINUMAN
                'barang_kode' => 'BRG004',
                'barang_nama' => 'Teh Botol Sosro 1 Liter',
                'harga_beli' => 7000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 5, // PERALATAN RUMAH TANGGA
                'barang_kode' => 'BRG005',
                'barang_nama' => 'Sapu Lantai Fiber',
                'harga_beli' => 25000,
                'harga_jual' => 35000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 1,
                'barang_kode' => 'BRG006',
                'barang_nama' => 'Kipas Angin Maspion',
                'harga_beli' => 150000,
                'harga_jual' => 180000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'BRG007',
                'barang_nama' => 'Celana Jeans Wanita',
                'harga_beli' => 120000,
                'harga_jual' => 160000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 3,
                'barang_kode' => 'BRG008',
                'barang_nama' => 'Biskuit Coklat Kaleng',
                'harga_beli' => 30000,
                'harga_jual' => 40000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 4,
                'barang_kode' => 'BRG009',
                'barang_nama' => 'Kopi Sachet 10x25gr',
                'harga_beli' => 17000,
                'harga_jual' => 22000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'BRG010',
                'barang_nama' => 'Setrika Philips',
                'harga_beli' => 250000,
                'harga_jual' => 290000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
