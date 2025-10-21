<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('pengetahuan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aturan')->unique();
            $table->string('kode_kipi');    
            $table->string('kode_gejala');  
            $table->float('mb');
            $table->float('md');
            $table->timestamps();

            // Foreign key constraint, sesuaikan nama tabel dan kolom
            $table->foreign('kode_kipi')->references('kode')->on('kategori_kipis')->onDelete('cascade');
            $table->foreign('kode_gejala')->references('kode')->on('gejalas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengetahuan');
    }
};
