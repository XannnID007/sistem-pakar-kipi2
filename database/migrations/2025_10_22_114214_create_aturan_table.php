<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aturan', function (Blueprint $table) {
            $table->string('id_aturan', 20)->primary();
            $table->string('kode_kategori_kipi', 4)->index();
            $table->string('kode_gejala', 4)->index();
            $table->float('mb');
            $table->float('md');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('aturan');
    }
};
