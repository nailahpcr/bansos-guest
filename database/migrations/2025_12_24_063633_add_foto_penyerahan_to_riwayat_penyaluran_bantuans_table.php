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
    Schema::table('riwayat_penyaluran_bantuans', function (Blueprint $table) {
        // Menambahkan kolom untuk bukti foto serah terima bantuan
        $table->string('foto_penyerahan')->nullable()->after('nilai');
    });
}

public function down(): void
{
    Schema::table('riwayat_penyaluran_bantuans', function (Blueprint $table) {
        $table->dropColumn('foto_penyerahan');
    });
}
};