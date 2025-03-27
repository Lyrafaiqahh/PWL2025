<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 5, 'barang_kode' => 'BRG001', 'barang_nama' => 'Barang 1', 'harga' => 51808, 'stok' => 3],
            ['barang_id' => 2, 'kategori_id' => 3, 'barang_kode' => 'BRG002', 'barang_nama' => 'Barang 2', 'harga' => 19836, 'stok' => 16],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Barang 3', 'harga' => 51356, 'stok' => 19],
            ['barang_id' => 4, 'kategori_id' => 4, 'barang_kode' => 'BRG004', 'barang_nama' => 'Barang 4', 'harga' => 69929, 'stok' => 41],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Barang 5', 'harga' => 14230, 'stok' => 18],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Barang 6', 'harga' => 91515, 'stok' => 21],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Barang 7', 'harga' => 31371, 'stok' => 24],
            ['barang_id' => 8, 'kategori_id' => 2, 'barang_kode' => 'BRG008', 'barang_nama' => 'Barang 8', 'harga' => 33925, 'stok' => 42],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Barang 9', 'harga' => 18904, 'stok' => 25],
            ['barang_id' => 10, 'kategori_id' => 3, 'barang_kode' => 'BRG010', 'barang_nama' => 'Barang 10', 'harga' => 95307, 'stok' => 28],
        ];

        DB::table('m_barang')->insert($data);
    }
}
