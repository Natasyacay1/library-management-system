<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Pegawai
        User::create([
            'name' => 'Pegawai Perpus',
            'email' => 'pegawai@perpus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa 1',
            'email' => 'mhs1@perpus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
    }
}
