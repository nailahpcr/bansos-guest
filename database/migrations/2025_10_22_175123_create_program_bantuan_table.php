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
        Schema::create('program_bantuan', function (Blueprint $table) {
            $table->increments('program_id');
            $table->string('kode',50)->unique();          
            $table->string('nama_program', 100);           
            $table->year('tahun');                        
            $table->text('deskripsi')->nullable();         
            $table->decimal('anggaran', 15, 2);            
            $table->timestamps();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_bantuan');
    }
};
