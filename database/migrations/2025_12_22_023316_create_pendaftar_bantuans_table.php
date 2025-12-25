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
        Schema::create('pendaftar_bantuans', function (Blueprint $table) {
            $table->id('pendaftar_id');
            $table->foreignId('program_id')->constrained('program_bantuan', 'program_id')->onDelete('cascade');
            $table->foreignId('warga_id')->constrained('warga', 'warga_id')->onDelete('cascade');
            $table->datetime('tanggal_daftar');
            $table->string('status_seleksi')->default('Pending'); // Possible values: Pending, Verifikasi, Ditolak, Diterima
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_bantuans');
    }
};
