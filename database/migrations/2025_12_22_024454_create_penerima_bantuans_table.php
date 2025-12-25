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
       Schema::create('penerima_bantuans', function (Blueprint $table) {
            $table->id('penerima_id');
            $table->foreignId('program_id')
                  ->constrained('program_bantuan', 'program_id')
                  ->cascadeOnDelete();
            $table->foreignId('warga_id')
                  ->constrained('warga', 'warga_id')
                  ->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuans');
    }
};
