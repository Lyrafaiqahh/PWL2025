<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user_id yang ada di m_user
        $userIds = DB::table('m_user')->pluck('user_id')->toArray();

        // Pastikan ada user_id yang tersedia
        if (empty($userIds)) {
            $this->command->warn("No users found in m_user, skipping stok seeding.");
            return;
        }

        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'barang_id' => $i, // Sesuaikan dengan barang yang ada
                'stok_id' => $i, // Jika stok_id auto-increment, ini bisa dihapus
                'stok_jumlah' => rand(1, 50),
                'stok_tanggal' => Carbon::now()->subDays(rand(1, 30)), // Tanggal stok acak dalam 30 hari terakhir
                'user_id' => $userIds[array_rand($userIds)], // Pilih user_id yang valid secara acak
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data ke dalam tabel t_stok
        DB::table('t_stok')->insert($data);
    }
}
