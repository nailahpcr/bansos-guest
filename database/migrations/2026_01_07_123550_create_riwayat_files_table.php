<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_id')->constrained('riwayat_penyaluran_bantuans', 'penyaluran_id')->onDelete('cascade');

            $table->string('filename');   // Nama asli file (Contoh: Sertifikat.pdf)
            $table->string('path');       // Lokasi penyimpanan (Contoh: riwayat_files/abc123.pdf)
            $table->string('mime_type');  // Tipe file (image/png, application/pdf)
            $table->integer('size');      // Ukuran file dalam bytes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_files');
    }
};