<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 20)->primary();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 60);
            $table->enum('role', ['pakar', 'orang_tua'])->default('orang_tua'); // 'pakar'
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
