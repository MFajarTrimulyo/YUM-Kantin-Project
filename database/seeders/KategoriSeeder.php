<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::insert([
            [   
                'id' => 'KAT250000',
                'nama' => 'Semua'
            ],
            [   
                'id' => 'KAT250001',
                'nama' => 'Makanan'
            ],
            [
                'id' => 'KAT250002',
                'nama' => 'Minuman'
            ],
            [
                'id' => 'KAT250003',
                'nama' => 'Camilan'
            ],
            [
                'id' => 'KAT250004',
                'nama' => 'Lainnya'
            ],
        ]);
    }
}
