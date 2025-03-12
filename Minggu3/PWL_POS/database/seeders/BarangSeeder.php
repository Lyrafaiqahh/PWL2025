<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'barang_kode' => 'BRG' . str_pad($i, 3, '0', STR_PAD_LEFT), // Kode unik seperti BRG001
                'barang_nama' => "Barang $i",
                'kategori_id' => rand(1, 5),
                'harga' => rand(10000, 100000),
                'stok' => rand(1, 50), // Tambahkan stok agar sesuai dengan tabel
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('m_barang')->insert($data);
    }
}
