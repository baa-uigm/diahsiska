<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studies', function (Blueprint $table) {
            $table->id();
            $table->string('npm')->nullable();
            $table->string('nama')->nullable();
            $table->string('prodi')->nullable();
            $table->string('kode_mk')->nullable();
            $table->string('nama_mk')->nullable();
            $table->integer('sks')->nullable();
            $table->string('huruf', 5)->nullable();
            $table->integer('tahun')->nullable();
            $table->string('fakultas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studies');
    }
};
