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
    Schema::create('pendaftar_files', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pendaftar_id'); // Foreign key ke pendaftar_bantuan
        $table->string('filename');
        $table->string('path');
        $table->string('mime_type')->nullable();
        $table->integer('size')->nullable();
        $table->timestamps();

        // Hubungkan foreign key ke primary key tabel pendaftar Anda
        $table->foreign('pendaftar_id')->references('pendaftar_id')->on('pendaftar_bantuans')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_files');
    }
};
