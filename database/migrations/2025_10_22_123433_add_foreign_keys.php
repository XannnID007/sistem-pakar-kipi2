<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('aturan', function (Blueprint $table) {
            $table->foreign('kode_gejala')->references('kode_gejala')->on('gejalas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kode_kategori_kipi')->references('kode_kategori_kipi')->on('kategori_kipis')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('diagnosa', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        Schema::table('gejala_dipilih', function (Blueprint $table) {
            $table->foreign('kode_gejala')->references('kode_gejala')->on('gejalas')->onUpdate('cascade');
            $table->foreign('id_diagnosa')->references('id_diagnosa')->on('diagnosa')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('laporan', function (Blueprint $table) {
            $table->foreign('id_diagnosa')->references('id_diagnosa')->on('diagnosa')->onDelete('set null');
        });

        Schema::table('diagnosa_kipi', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        Schema::table('notifikasis', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('aturan', function (Blueprint $table) {
            $table->dropForeign(['kode_gejala', 'kode_kategori_kipi']);
        });
        Schema::table('diagnosa', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        Schema::table('gejala_dipilih', function (Blueprint $table) {
            $table->dropForeign(['kode_gejala', 'id_diagnosa']);
        });
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_diagnosa']);
        });
        Schema::table('diagnosa_kipi', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });
    }
};
