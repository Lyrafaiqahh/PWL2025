<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_kategori')->insert([
            ['kategori_kode' => 'ELEC', 'kategori_nama' => 'Elektronik'],
            ['kategori_kode' => 'PAK', 'kategori_nama' => 'Pakaian'],
            ['kategori_kode' => 'MAK', 'kategori_nama' => 'Makanan'],
            ['kategori_kode' => 'MIN', 'kategori_nama' => 'Minuman'],
            ['kategori_kode' => 'PRT', 'kategori_nama' => 'Peralatan Rumah Tangga'],
        ]);
    }
}



