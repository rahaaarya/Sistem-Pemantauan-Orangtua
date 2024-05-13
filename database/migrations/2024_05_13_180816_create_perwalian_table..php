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
        Schema::create('perwalian', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_dosen');
            $table->unsignedInteger('id_mahasiswa');
            $table->string('nama_mahasiswa');
            $table->string('nama_dosen');
            $table->string('nim');
            $table->string('nidn');
            $table->timestamps();

            // Menambahkan foreign key constraint ke tabel dosen
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('cascade');

            // Menambahkan foreign key constraint ke tabel mahasiswa
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perwalian');
    }
};
