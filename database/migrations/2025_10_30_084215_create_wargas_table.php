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
        Schema::create('warga', function (Blueprint $table) {
            $table->id('warga_id');
            $table->string('no_ktp', 16)->unique();
            $table->string('nama', 255);

            // TAMBAHKAN KOLOM UNTUK LOGIN
            $table->string('email', 100)->unique(); // Pindahkan dari controller
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken(); // Untuk fitur "Ingat Saya"

            // Sisa kolom biodata Anda
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama', 50);
            $table->string('pekerjaan', 100)->nullable();
            $table->string('telp', 15)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
