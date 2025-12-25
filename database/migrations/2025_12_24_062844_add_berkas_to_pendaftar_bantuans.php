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
    Schema::table('pendaftar_bantuans', function (Blueprint $table) {
        // Menambahkan kolom untuk menyimpan foto struk/berkas pendaftaran
        $table->string('foto_berkas')->nullable()->after('keterangan');
    });
}

public function down(): void
{
    Schema::table('pendaftar_bantuans', function (Blueprint $table) {
        $table->dropColumn('foto_berkas');
    });
}
};