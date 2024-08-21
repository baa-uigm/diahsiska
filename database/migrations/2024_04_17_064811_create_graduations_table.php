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
        Schema::create('graduations', function (Blueprint $table) {
            $table->id();
            $table->string('npm')->unique();
            $table->string('nama');
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('jenjang');
            $table->enum('jk', ['Laki-Laki', 'Perempuan'])->default('Laki-Laki');
            $table->date('masuk');
            $table->date('lulus');
            $table->integer('ditempuh');
            $table->float('ipk');
            $table->float('lama');
            $table->integer('tahun');
            $table->integer('wisuda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduations');
    }
};
