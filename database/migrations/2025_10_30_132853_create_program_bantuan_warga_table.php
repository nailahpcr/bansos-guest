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
        Schema::create('program_bantuan_warga', function (Blueprint $table) {
            $table->id();
            
            // Kunci asing ke tabel 'program_bantuan'
            $table->foreignId('program_bantuan_program_id')
                  ->constrained('program_bantuan', 'program_id') // Ke tabel & kolom yang benar
                  ->onDelete('cascade');

            // Kunci asing ke tabel 'warga'
            $table->foreignId('warga_warga_id')
                  ->constrained('warga', 'warga_id') // Ke tabel & kolom yang benar
                  ->onDelete('cascade');

            // Kolom status untuk melacak pengajuan
            $table->enum('status', ['Diajukan', 'Diterima', 'Ditolak'])->default('Diajukan');
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_bantuan_warga');
    }
};
