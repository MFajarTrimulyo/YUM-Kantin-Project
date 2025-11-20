<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 'USR250000',
                'photo'     => null,
                'nama'      => 'Admin YUM',
                'username'  => 'adminyum',
                'email'     => 'admin@yum-kantin.com',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin'
            ],
            [
                'id' => 'USR250001',
                'photo'     => null,
                'nama'      => 'Dummy User',
                'username'  => 'dummyuser',
                'email'     => 'dummyuser@yum-kantin.com',
                'password'  => Hash::make('dummy123'),
                'role'      => 'user'   
            ],
        ]);
    }
}
