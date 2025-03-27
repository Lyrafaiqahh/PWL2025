<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            BarangSeeder::class,
            StokSeeder::class,
            PenjualanSeeder::class,
            PenjualanDetailSeeder::class,
            LevelSeeder::class,   // Tambahkan ini
            UserSeeder::class,    // Tambahkan ini
        ]);
    }
}
