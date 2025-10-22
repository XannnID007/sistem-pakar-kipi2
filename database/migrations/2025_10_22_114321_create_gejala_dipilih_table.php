<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gejala_dipilih', function (Blueprint $table) {
            $table->string('id_gejala_dipilih', 20)->primary();
            $table->string('id_diagnosa', 20)->index();
            $table->string('kode_gejala', 4)->index();
            $table->float('cf_user');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('gejala_dipilih');
    }
};
