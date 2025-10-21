<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKipiSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_kipis')->insert([
            [
                'kode' => 'K001',
                'jenis_kipi' => 'Ringan',
                'saran' => 'Pemantauan di rumah dan berikan obat pereda demam jika diperlukan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'K002',
                'jenis_kipi' => 'Sedang',
                'saran' => 'Segera konsultasikan ke dokter untuk observasi lebih lanjut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'K003',
                'jenis_kipi' => 'Berat',
                'saran' => 'Segera bawa ke fasilitas kesehatan untuk penanganan darurat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
