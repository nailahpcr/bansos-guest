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
        if (!Schema::hasTable('verifikasi_lapangans')) {
            Schema::create('verifikasi_lapangans', function (Blueprint $table) {
                $table->id('verifikasi_id');

                $table->foreignId('pendaftar_id')
                  ->constrained('pendaftar_bantuans', 'pendaftar_id')
                  ->onDelete('cascade');
                
                $table->string('petugas');
                $table->date('tanggal');
                $table->text('catatan')->nullable(); 
                $table->integer('skor');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_lapangans');
    }
};

