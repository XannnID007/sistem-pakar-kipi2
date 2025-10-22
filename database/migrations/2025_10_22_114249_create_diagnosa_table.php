<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('diagnosa', function (Blueprint $table) {
            $table->string('id_diagnosa', 20)->primary();
            $table->string('id_user', 20)->index();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('nama_anak', 100)->nullable();
            $table->integer('usia_anak')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('jenis_kipi', 100)->nullable();
            $table->float('nilai_cf')->nullable();
            $table->text('saran')->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jenis_vaksin', 100)->nullable();
            $table->string('tempat_imunisasi', 100)->nullable();
            $table->date('tanggal_imunisasi')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('diagnosa');
    }
};
