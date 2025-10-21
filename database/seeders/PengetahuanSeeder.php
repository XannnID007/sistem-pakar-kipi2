<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengetahuanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengetahuan')->insert([
            [
                'kode_aturan' => 'R001',
                'kode_kipi' => 'K001',
                'kode_gejala' => 'G001',
                'mb' => 0.8,
                'md' => 0.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_aturan' => 'R002',
                'kode_kipi' => 'K002',
                'kode_gejala' => 'G002',
                'mb' => 0.6,
                'md' => 0.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
