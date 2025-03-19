<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->truncate(); // Menghapus semua data lama

        DB::table('m_kategori')->insert([
            [
                'kategori_id' => 1,
                'kategori_kode' => 'CML',
                'kategori_nama' => 'Cemilan',
                'created_at' => '2024-03-09 10:30:00',
                'updated_at' => null
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'MNR',
                'kategori_nama' => 'Minuman Ringan',
                'created_at' => '2024-03-09 13:01:39',
                'updated_at' => null
            ]
        ]);
    }
}
