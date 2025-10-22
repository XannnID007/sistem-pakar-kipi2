<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
// Hapus 'use Illuminate\Support\Facades\DB;' jika tidak dipakai lagi

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User Pakar (Email: bidan@mail.com)
        User::create([
            'name' => 'Pakar',
            'email' => 'pakar@mail.com',
            'password' => '$2y$12$trOwEOeu1/LCTWaHD2O67OM3XNjQzuRMgQXZ83j6UY7cc.caZpj/K',
            'role' => 'pakar',
            'created_at' => '2025-09-09 16:10:25',
            'updated_at' => '2025-09-09 16:10:25'
        ]);

        // 2. User Orang Tua 1
        User::create([
            'name' => 'Fitri Rahmawati',
            'email' => 'fitri@mail.com',
            'password' => '$2y$12$Sab26N/2q9Zx5Z/0LKcdK.rt7iUn/1m6ASktw3KeiYqlqJmCCzt9K',
            'role' => 'orang_tua',
            'created_at' => '2025-09-18 12:57:17',
            'updated_at' => '2025-09-18 12:57:17'
        ]);

        // 3. User Orang Tua 2
        User::create([
            'name' => 'Fitri Rahmawati',
            'email' => 'fitrirahmawati287@gmail.com',
            'password' => '$2y$12$bc3BTiDGRJP93QoV7xvHx.vyMov9ucAUJtC4gHaRG98oC3Wc5ekmG',
            'role' => 'orang_tua',
            'created_at' => '2025-09-18 16:15:26',
            'updated_at' => '2025-09-18 16:15:26'
        ]);

        // HAPUS: Blok kode untuk mengisi tabel password_resets
    }
}
