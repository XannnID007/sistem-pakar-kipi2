<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_kipis', function (Blueprint $table) {
            $table->string('kode_kategori_kipi', 4)->primary();
            $table->string('jenis_kipi', 25);
            $table->text('saran');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kategori_kipis');
    }
};
