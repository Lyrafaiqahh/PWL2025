<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $barangList = DB::table('m_barang')->get(); // Ambil semua data barang dari tabel
        $data = [];

        for ($penjualanId = 1; $penjualanId <= 10; $penjualanId++) {
            // Ambil 3 barang secara acak, tidak duplikat
            $barangDipilih = $barangList->random(3);

            foreach ($barangDipilih as $barang) {
                $jumlah = rand(1, 5);
                $data[] = [
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $barang->barang_id,
                    'harga' => $barang->harga_jual,
                    'jumlah' => $jumlah,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}
