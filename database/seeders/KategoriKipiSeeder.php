<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriKipi;

class KategoriKipiSeeder extends Seeder
{
    public function run(): void
    {
        KategoriKipi::create([
            'kode_kategori_kipi' => 'K001',
            'jenis_kipi' => 'Ringan (reaksi lokal)',
            'saran' => 'Lakukan kompres dingin pada area suntikan, jangan dipijat, tetap pantau suhu tubuh bayi, dan segera konsultasikan ke tenaga kesehatan jika bengkak atau nyeri menetap lebih dari 48 jam.',
            'created_at' => '2025-09-09 15:48:46',
            'updated_at' => '2025-09-09 15:48:46',
        ]);
        KategoriKipi::create([
            'kode_kategori_kipi' => 'K002',
            'jenis_kipi' => 'Ringan (reaksi sistemik)',
            'saran' => 'Berikan ASI lebih sering untuk mencegah dehidrasi, pakaikan pakaian tipis, kompres hangat jika demam, biarkan anak istirahat cukup, atau segera bawa ke fasilitas kesehatan bila gejala tidak membaik dalam 48 jam.',
            'created_at' => '2025-09-09 15:48:46',
            'updated_at' => '2025-09-09 15:48:46',
        ]);
        KategoriKipi::create([
            'kode_kategori_kipi' => 'K003',
            'jenis_kipi' => 'Berat',
            'saran' => 'Segera bawa ke fasilitas kesehatan untuk penanganan darurat.',
            'created_at' => '2025-09-09 15:48:46',
            'updated_at' => '2025-09-09 15:48:46',
        ]);
    }
}
