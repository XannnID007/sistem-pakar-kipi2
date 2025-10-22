<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->string('id_laporan', 20)->primary();
            $table->string('id_diagnosa', 20)->nullable()->index();
            $table->enum('jenis_laporan', ['KIPI Berat', 'KIPI Bulanan']);
            $table->date('tanggal_laporan');
            $table->string('file_path', 100);
            $table->string('nama_file', 100);
            $table->timestamps();
        });

        Schema::create('diagnosa_kipi', function (Blueprint $table) {
            $table->string('id_diagnosa_kipi', 20)->primary();
            $table->string('id_user', 20)->index();
            $table->string('nama_anak');
            $table->string('nama_ibu');
            $table->date('tanggal_lahir')->nullable();
            $table->string('usia_anak');
            $table->string('alamat')->nullable();
            $table->string('jenis_vaksin')->nullable();
            $table->string('tempat_imunisasi')->nullable();
            $table->date('tanggal_imunisasi')->nullable();
            $table->date('tanggal_diagnosa');
            $table->string('diagnosa');
            $table->double('nilai_cf');
            $table->json('gejala_dipilih')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();
        });

        Schema::create('notifikasis', function (Blueprint $table) {
            $table->string('id_notifikasi', 20)->primary();
            $table->string('id_user', 20)->index(); // Mengganti pakar_id
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('pengetahuan', function (Blueprint $table) {
            $table->string('id_pengetahuan', 20)->primary();
            $table->string('kode_aturan');
            $table->string('kode_kipi');
            $table->string('kode_gejala');
            $table->double('mb');
            $table->double('md');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('diagnosa_kipi');
        Schema::dropIfExists('notifikasis');
        Schema::dropIfExists('pengetahuan');
    }
};
