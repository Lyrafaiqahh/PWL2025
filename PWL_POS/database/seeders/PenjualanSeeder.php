<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'user_id' => rand(1, 3), // Random user dari m_user (1 = Admin, 2 = Manager, 3 = Staff)
                'tanggal' => now()->subDays(rand(0, 30)), // Tanggal random dalam 30 hari terakhir
                'total_harga' => rand(50000, 500000), // Harga antara 50rb - 500rb
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}
