<?php

namespace Database\Seeders;

use App\Models\Kantin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KantinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kantins')->insert([
            [
                'nama' => 'Kantin FIP'
            ],
            [
                'nama' => 'Kantin FMIPA'
            ],
            [
                'nama' => 'Kantin FS'
            ],
            [
                'nama' => 'Kantin FEB'
            ],
            [
                'nama' => 'Kantin FIS'
            ],
            [
                'nama' => 'Kantin FK'
            ],
        ]);
    }
}
