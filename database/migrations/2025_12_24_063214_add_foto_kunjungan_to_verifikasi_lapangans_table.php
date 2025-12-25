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
    Schema::table('verifikasi_lapangans', function (Blueprint $table) {
        // Menambahkan kolom foto_kunjungan setelah catatan
        $table->string('foto_kunjungan')->nullable()->after('catatan');
    });
}

public function down(): void
{
    Schema::table('verifikasi_lapangans', function (Blueprint $table) {
        $table->dropColumn('foto_kunjungan');
    });
}
};
