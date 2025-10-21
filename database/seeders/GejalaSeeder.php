<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gejala;

class GejalaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode' => 'G001', 'nama' => 'Ruam dan gatal di kulit'],
            ['kode' => 'G002', 'nama' => 'Batuk dan bersin'],
            ['kode' => 'G003', 'nama' => 'Sesak napas'],
            ['kode' => 'G004', 'nama' => 'Pusing'],
            ['kode' => 'G005', 'nama' => 'Detak jantung cepat'],
            ['kode' => 'G006', 'nama' => 'Sakit kepala'],
            ['kode' => 'G007', 'nama' => 'Mual'],
            ['kode' => 'G008', 'nama' => 'Muntah'],
            ['kode' => 'G009', 'nama' => 'Diare'],
            ['kode' => 'G010', 'nama' => 'Demam'],
            ['kode' => 'G011', 'nama' => 'Lemas'],
            ['kode' => 'G012', 'nama' => 'Rewel'],
            ['kode' => 'G013', 'nama' => 'Muncul timbul bisul kecil (papula)'],
            ['kode' => 'G014', 'nama' => 'Otot lemah'],
        ];

        foreach ($data as $gejala) {
            Gejala::updateOrCreate(['kode' => $gejala['kode']], $gejala);
        }
    }
}
