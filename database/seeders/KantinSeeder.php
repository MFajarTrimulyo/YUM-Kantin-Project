<?php

namespace Database\Seeders;

use App\Models\Kantin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KantinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kantin::create([
            [
                'nama' => 'Kantin FIP',
            ],
            [
                'nama' => 'Kantin FMIPA',
            ],
            [
                'nama' => 'Kantin FS',
            ],
            [
                'nama' => 'Kantin FEB',
            ],
            [
                'nama' => 'Kantin FIS',
            ],
            [
                'nama' => 'Kantin FK',
            ],
        ]);
    }
}
