<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $harga_satuan = rand(10000, 50000); // Harga satuan barang
            $jumlah = rand(1, 5); // Jumlah barang yang dibeli
            $total_harga = $harga_satuan * $jumlah; // Hitung total harga

            $data[] = [
                'penjualan_id' => rand(1, 10), // Ambil ID dari tabel t_penjualan
                'barang_id' => rand(1, 10), // Ambil ID dari barang
                'jumlah' => $jumlah,
                'harga_satuan' => $harga_satuan,
                'total_harga' => $total_harga, // Total harga (harga satuan x jumlah)
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}
