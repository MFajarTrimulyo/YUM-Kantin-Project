<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rekenings')->insert([
            [
                'id' => 'REK001',
                'nama_bank' => 'Bank BRI',
                'nomor_rekening' => '1234-5678-9012-3456',
                'atas_nama' => 'YUM Official',
                'is_active' => true,
            ],
            [
                'id' => 'REK002',
                'nama_bank' => 'Bank BCA',
                'nomor_rekening' => '8880-1234-5678',
                'atas_nama' => 'YUM Official',
                'is_active' => true,
            ],
            [
                'id' => 'REK003',
                'nama_bank' => 'E-Wallet DANA',
                'nomor_rekening' => '0812-3456-7890',
                'atas_nama' => 'YUM Official',
                'is_active' => true,
            ],
        ]);
    }
}
