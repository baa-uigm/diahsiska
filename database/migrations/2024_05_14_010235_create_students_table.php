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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('npm')->unique();
            $table->string('nama');
            $table->enum('jk', ['Laki-Laki', 'Perempuan'])->default('Laki-Laki');
            $table->enum('agama', ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KHONGHUCU'])->default('ISLAM');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('program_kuliah');
            $table->string('prodi');
            $table->string('status_mhs');
            $table->string('tahun_masuk');
            $table->string('jenis_beasiswa')->nullable();
            $table->float('ipk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
