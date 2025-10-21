<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PakarSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'bidan@mail.com'],
            [
                'name' => 'Bidan desa',
                'password' => Hash::make('bidan123'),
                'role' => 'bidan_desa'
            ]
        );
         // Seeder untuk kepala puskesmas
    User::create([
        'name' => 'Kepala Puskesmas',
        'email' => 'kepala@puskesmas.com',
        'password' => Hash::make('kepala123'),
        'role' => 'kepala_puskesmas',
    ]);
    }
}

