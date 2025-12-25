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
        Schema::create('riwayat_penyaluran_bantuans', function (Blueprint $table) {
            $table->id('penyaluran_id');
            $table->foreignId('program_id')
                  ->constrained('program_bantuan', 'program_id')
                  ->cascadeOnDelete();
            $table->foreignId('penerima_id')
                  ->constrained('penerima_bantuans', 'penerima_id')
                  ->cascadeOnDelete();
            $table->integer('tahap_ke');
            $table->date('tanggal');
            $table->decimal('nilai', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penyaluran_bantuans');
    }
};
