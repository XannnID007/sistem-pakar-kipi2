<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aturan;

class AturanSeeder extends Seeder
{
    public function run(): void
    {
        $aturan = [
            ['kode_kategori_kipi' => 'K001', 'kode_gejala' => 'G001', 'mb' => 1, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K001', 'kode_gejala' => 'G002', 'mb' => 0.8, 'md' => 0.2],
            ['kode_kategori_kipi' => 'K001', 'kode_gejala' => 'G003', 'mb' => 0.9, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K001', 'kode_gejala' => 'G004', 'mb' => 1, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K001', 'kode_gejala' => 'G005', 'mb' => 1, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G006', 'mb' => 0.9, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G007', 'mb' => 0.6, 'md' => 0.3],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G008', 'mb' => 0.5, 'md' => 0.4],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G009', 'mb' => 0.6, 'md' => 0.2],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G010', 'mb' => 0.7, 'md' => 0.3],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G011', 'mb' => 0.6, 'md' => 0.3],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G012', 'mb' => 0.8, 'md' => 0.4],
            ['kode_kategori_kipi' => 'K002', 'kode_gejala' => 'G013', 'mb' => 0.7, 'md' => 0.5],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G014', 'mb' => 1, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G015', 'mb' => 1, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G016', 'mb' => 1, 'md' => 0.1],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G017', 'mb' => 0.8, 'md' => 0.3],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G018', 'mb' => 0.8, 'md' => 0.2],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G019', 'mb' => 0.7, 'md' => 0.4],
            ['kode_kategori_kipi' => 'K003', 'kode_gejala' => 'G020', 'mb' => 0.9, 'md' => 0.1],
        ];

        foreach ($aturan as $rule) {
            Aturan::create($rule);
        }
    }
}
