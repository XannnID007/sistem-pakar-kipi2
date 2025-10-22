<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gejala;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $gejalas = [
            ['kode_gejala' => 'G001', 'nama_gejala' => 'Nyeri di tempat suntikan'],
            ['kode_gejala' => 'G002', 'nama_gejala' => 'Bengkak ringan di lokasi suntikan'],
            ['kode_gejala' => 'G003', 'nama_gejala' => 'Gatal disekitar area suntikan'],
            ['kode_gejala' => 'G004', 'nama_gejala' => 'Kemerahan ditempat suntikan'],
            ['kode_gejala' => 'G005', 'nama_gejala' => 'Hangat disekitar suntikan'],
            ['kode_gejala' => 'G006', 'nama_gejala' => 'Demam ringan'],
            ['kode_gejala' => 'G007', 'nama_gejala' => 'Rewel atau menangis terus menerus'],
            ['kode_gejala' => 'G008', 'nama_gejala' => 'Penurunan napsu makan'],
            ['kode_gejala' => 'G009', 'nama_gejala' => 'Pusing'],
            ['kode_gejala' => 'G010', 'nama_gejala' => 'Sakit kepala'],
            ['kode_gejala' => 'G011', 'nama_gejala' => 'Ruam ringan dikulit tanpa bengkak'],
            ['kode_gejala' => 'G012', 'nama_gejala' => 'Anak tampak lemas tapi masih responsif'],
            ['kode_gejala' => 'G013', 'nama_gejala' => 'Mual atau muntah'],
            ['kode_gejala' => 'G014', 'nama_gejala' => 'Ruam dan gatal diseluruh tubuh'],
            ['kode_gejala' => 'G015', 'nama_gejala' => 'Kejang'],
            ['kode_gejala' => 'G016', 'nama_gejala' => 'Sesak napas'],
            ['kode_gejala' => 'G017', 'nama_gejala' => 'Detak jantung cepat'],
            ['kode_gejala' => 'G018', 'nama_gejala' => 'Pembengkakan dibibir atau wajah'],
            ['kode_gejala' => 'G019', 'nama_gejala' => 'Demam tinggi'],
            ['kode_gejala' => 'G020', 'nama_gejala' => 'Penurunan kesadaran'],
        ];

        foreach ($gejalas as $gejala) {
            Gejala::create($gejala);
        }
    }
}
