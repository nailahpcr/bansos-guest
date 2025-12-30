<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('verifikasi_files', function (Blueprint $table) {
        $table->id();
        // 1. Definisikan kolomnya dulu
        $table->unsignedBigInteger('verifikasi_id'); 
        $table->string('filename');
        $table->string('path');
        $table->timestamps();

        // 2. Baru buat foreign key-nya
        $table->foreign('verifikasi_id')
              ->references('verifikasi_id') // Harus sesuai PK di tabel verifikasi_lapangans
              ->on('verifikasi_lapangans')
              ->onDelete('cascade');
    });

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_files');
    }
};
