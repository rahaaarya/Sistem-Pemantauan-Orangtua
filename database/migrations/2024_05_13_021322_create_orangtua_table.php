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
        Schema::create('orangtua', function (Blueprint $table) {
            $table->bigIncrements('id_orangtua'); // Primary key yang diincrement secara otomatis
            $table->string('nama_ayah', 255);
            $table->string('nama_ibu', 255);
            $table->string('pekerjaan_ayah', 255);
            $table->string('pekerjaan_ibu', 255);
            $table->string('email', 100)->unique();
            $table->string('no_telepon', 20);
            $table->string('hubungan', 20);
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};
