<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Masih dipakai untuk truncate tabel bawaan

// Import model untuk truncate (opsional, bisa pakai DB::table juga)
use App\Models\User;
use App\Models\KategoriKipi;
use App\Models\Gejala;
use App\Models\Aturan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Truncate tabel (kosongkan)
        // Hanya tabel yang akan di-seed
        Aturan::truncate();
        Gejala::truncate();
        KategoriKipi::truncate();
        User::truncate();
        DB::table('password_resets')->truncate(); // Tetap kosongkan ini

        // HAPUS: Truncate untuk diagnosa, gejala_dipilih, laporan

        Schema::enableForeignKeyConstraints();

        // Panggil seeder individual
        $this->call([
            KategoriKipiSeeder::class,
            GejalaSeeder::class,
            AturanSeeder::class,
            UserSeeder::class,
            // HAPUS: DiagnosaSeeder::class
        ]);
    }
}
