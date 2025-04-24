<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_id' => 1,
                'kode_supplier' => 'SUP001',
                'nama_supplier' => 'CV Sumber Elektronik',
                'alamat' => 'Jl. Listrik No. 10, Jakarta',
                'kategori_id' => 1, // ELEC
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_id' => 2,
                'kode_supplier' => 'SUP002',
                'nama_supplier' => 'PT Fashionindo',
                'alamat' => 'Jl. Jahit No. 5, Bandung',
                'kategori_id' => 2, // PAK
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_id' => 3,
                'kode_supplier' => 'SUP003',
                'nama_supplier' => 'UD Saji Nikmat',
                'alamat' => 'Jl. Rasa No. 88, Surabaya',
                'kategori_id' => 3, // MAK
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_id' => 4,
                'kode_supplier' => 'SUP004',
                'nama_supplier' => 'PT Segar Sehat',
                'alamat' => 'Jl. Segar No. 9, Yogyakarta',
                'kategori_id' => 4, // MIN
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_id' => 5,
                'kode_supplier' => 'SUP005',
                'nama_supplier' => 'CV Rumah Tangga Jaya',
                'alamat' => 'Jl. Perabot No. 77, Semarang',
                'kategori_id' => 5, // PRT
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}

