<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_kepalas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak');
            $table->string('nama_ibu');
            $table->date('tanggal_lahir')->nullable();
            $table->string('usia_anak');
            $table->string('alamat')->nullable();
            $table->date('tanggal_diagnosa');
            $table->string('diagnosa');
            $table->float('nilai_cf');
            $table->json('gejala_dipilih')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kepalas');
    }
};
