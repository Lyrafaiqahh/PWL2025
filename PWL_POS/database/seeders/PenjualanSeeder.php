<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $pembeli = [
            'Andi Saputra',
            'Rina Lestari',
            'Budi Santoso',
            'Siti Nurhaliza',
            'Dedi Kurniawan',
            'Fitriani Putri',
            'Agus Salim',
            'Linda Mariana',
            'Yoga Pratama',
            'Nia Ramadhani',
        ];

        $data = [];
        foreach ($pembeli as $index => $nama) {
            $no = $index + 1;
            $data[] = [
                'penjualan_id' => $no,
                'user_id' => 3,
                'pembeli' => $nama,
                'penjualan_kode' => 'PJ-' . str_pad($no, 4, '0', STR_PAD_LEFT),
                'penjualan_tanggal' => now()->subDays(rand(0, 10)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}
