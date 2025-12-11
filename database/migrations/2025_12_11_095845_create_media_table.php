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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            // Kolom untuk Relasi Polimorfik
            $table->string('ref_table', 50); // Nama tabel asal (e.g., 'program_bantuan')
            $table->unsignedBigInteger('ref_id'); // ID dari baris asal
            
            // Detail File
            $table->string('file_name', 255); // Nama file di server
            $table->string('caption', 255)->nullable(); // Keterangan
            $table->string('mime_type', 50)->nullable(); // Jenis file
            $table->integer('sort_order')->default(0); // Urutan

            $table->timestamps();

            $table->index(['ref_table', 'ref_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
