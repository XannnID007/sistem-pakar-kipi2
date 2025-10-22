<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diagnosa;
use App\Models\GejalaDipilih;
use App\Models\User;
use App\Models\Laporan;
use App\Models\Gejala;

class DiagnosaSeeder extends Seeder
{
     public function run(): void
     {
          Diagnosa::truncate();
          GejalaDipilih::truncate();
          Laporan::truncate();

          // 1. Ambil User 'Fitri'
          $user3 = User::where('email', 'fitri@mail.com')->first();

          // Jika user tidak ada, jangan lanjutkan
          if (!$user3) {
               $this->command->error('User fitri@mail.com tidak ditemukan. Jalankan UsersSeeder dahulu.');
               return;
          }

          // 2. Buat Diagnosa 1 (dulu ID 1 & 2)
          $diag1 = Diagnosa::create([
               'id_user' => $user3->id_user,
               'nama_ibu' => 'tini',
               'nama_anak' => 'Mla',
               'usia_anak' => 13,
               'tanggal' => '2025-09-18',
               'jenis_kipi' => 'Ringan (reaksi sistemik)',
               'nilai_cf' => 0.8,
               'saran' => 'Berikan ASI lebih sering untuk mencegah dehidrasi, pakaikan pakaian tipis, kompres hangat jika demam, biarkan anak istirahat cukup, atau segera bawa ke fasilitas kesehatan bila gejala tidak membaik dalam 48 jam.',
               'jenis_kelamin' => 'Perempuan',
               'tanggal_lahir' => '2025-09-19',
               'alamat' => 'bandung',
               'jenis_vaksin' => 'bcg',
               'tempat_imunisasi' => 'posyandu melati',
               'tanggal_imunisasi' => '2025-09-19',
               'is_read' => 0,
               'created_at' => '2025-09-18 14:50:08',
               'updated_at' => '2025-09-18 14:50:09'
          ]);

          // 3. Buat Gejala Dipilih untuk Diagnosa 1
          // (Data asli: G006=1, G007=1, G016=0.5. Sisanya 0)
          $this->seedGejalaUntukDiagnosa($diag1->id_diagnosa, ['G006' => 1, 'G007' => 1, 'G016' => 0.5], '2025-09-18 14:50:09');

          // 4. Buat Diagnosa 2 (dulu ID 9)
          $diag9 = Diagnosa::create([
               'id_user' => $user3->id_user,
               'nama_ibu' => 'enung',
               'nama_anak' => 'habib',
               'usia_anak' => 23,
               'tanggal' => '2025-10-07',
               'jenis_kipi' => 'Berat',
               'nilai_cf' => 0.45,
               'saran' => 'Segera bawa ke fasilitas kesehatan untuk penanganan darurat.',
               'jenis_kelamin' => 'Laki-laki',
               'tanggal_lahir' => '2025-10-07',
               'alamat' => 'bdg',
               'jenis_vaksin' => 'polio',
               'tempat_imunisasi' => 'posyandu melati',
               'tanggal_imunisasi' => '2025-10-15',
               'is_read' => 1,
               'created_at' => '2025-10-06 17:26:55',
               'updated_at' => '2025-10-06 17:57:30'
          ]);

          // 5. Buat Gejala Dipilih untuk Diagnosa 2
          // (Data asli: G015=0.5, G016=0.5, G017=0.5. Sisanya 0)
          $this->seedGejalaUntukDiagnosa($diag9->id_diagnosa, ['G015' => 0.5, 'G016' => 0.5, 'G017' => 0.5], '2025-10-06 17:26:55');

          // 6. Seed Laporan
          Laporan::create([
               'id_diagnosa' => $diag9->id_diagnosa, // Relasi ke ID acak $diag9
               'jenis_laporan' => 'KIPI Berat',
               'tanggal_laporan' => '2025-10-07',
               'file_path' => 'storage/laporan/Laporan_KIPI_Berat_20251007_004513.pdf',
               'nama_file' => 'Laporan_KIPI_Berat_20251007_004513.pdf',
               'created_at' => '2025-10-06 17:45:13',
               'updated_at' => '2025-10-06 17:45:13',
          ]);

          // Laporan tanpa diagnosa (id_diagnosa = null)
          Laporan::create([
               'id_diagnosa' => null,
               'jenis_laporan' => 'KIPI Bulanan',
               'tanggal_laporan' => '2025-10-07',
               'file_path' => 'storage/laporan/Laporan_KIPI_Bulanan_September_2025_20251007_000251.pdf',
               'nama_file' => 'Laporan_KIPI_Bulanan_September_2025_20251007_000251.pdf',
               'created_at' => '2025-10-06 17:02:51',
               'updated_at' => '2025-10-06 17:02:51',
          ]);
          Laporan::create([
               'id_diagnosa' => null,
               'jenis_laporan' => 'KIPI Bulanan',
               'tanggal_laporan' => '2025-10-07',
               'file_path' => 'storage/laporan/Laporan_KIPI_Bulanan_September_2025_20251007_000746.pdf',
               'nama_file' => 'Laporan_KIPI_Bulanan_September_2025_20251007_000746.pdf',
               'created_at' => '2025-10-06 17:07:47',
               'updated_at' => '2025-10-06 17:07:47',
          ]);

          // Laporan dengan relasi ID lama yg tidak ada (id_diagnosa 6)
          // Kita biarkan saja, atau kita buat ID acak baru
          // Kita abaikan saja karena ID 6 tidak ada di data diagnosa kita
     }

     /** Helper untuk mengisi semua 20 gejala dengan nilai default 0, kecuali yg dipilih */
     private function seedGejalaUntukDiagnosa(string $diagnosaId, array $gejalaDipilih, string $timestamp)
     {
          // Ambil semua kode gejala dari DB
          $allGejalaCodes = Gejala::pluck('kode_gejala');

          foreach ($allGejalaCodes as $kode) {
               $cf = $gejalaDipilih[$kode] ?? 0; // Ambil nilai CF jika ada, jika tidak 0

               GejalaDipilih::create([
                    'id_diagnosa' => $diagnosaId,
                    'kode_gejala' => $kode,
                    'cf_user' => $cf,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
               ]);
          }
     }
}
