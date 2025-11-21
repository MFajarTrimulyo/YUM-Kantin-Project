<?php

namespace Database\Seeders;

use App\Models\Kantin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KantinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('kantins')->insert([
            [
                'nama'        => 'Kantin FIS',
                'photo'       => 'pictures/kantin/FIS.jpg',
                'lokasi'      => 'Fakultas Ilmu Sosial',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin FK',
                'photo'       => 'pictures/kantin/FK.jpg',
                'lokasi'      => 'Fakultas Kedokteran',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin FMIPA',
                'photo'       => 'pictures/kantin/FMIPA.jpg',
                'lokasi'      => 'Fakultas MIPA',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin FS',
                'photo'       => 'pictures/kantin/FS.jpg',
                'lokasi'      => 'Fakultas Sastra',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin GKB A19',
                'photo'       => 'pictures/kantin/GKB_A19.jpg',
                'lokasi'      => 'Gedung Kuliah Bersama A19',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin GKB A20',
                'photo'       => 'pictures/kantin/GKB_A20.jpg',
                'lokasi'      => 'Gedung Kuliah Bersama A20',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin Kenanga',
                'photo'       => 'pictures/kantin/Kenanga.jpg',
                'lokasi'      => 'Area Pusat',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin KPRI',
                'photo'       => 'pictures/kantin/KPRI.jpg',
                'lokasi'      => 'KPRI UM',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin FIP Lama',
                'photo'       => 'pictures/kantin/FIP_Lama.jpg',
                'lokasi'      => 'Fakultas Ilmu Pendidikan',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin FEB',
                'photo'       => 'pictures/kantin/FEB.jpg',
                'lokasi'      => 'Fakultas Ekonomi Bisnis',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama'        => 'Kantin FIP Baru',
                'photo'       => 'pictures/kantin/FIP_Baru.jpg',
                'lokasi'      => 'Fakultas Ilmu Pendidikan',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}