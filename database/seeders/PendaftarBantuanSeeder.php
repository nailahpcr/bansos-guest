<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ProgramBantuan; 
use App\Models\Warga;
use Faker\Factory as Faker;

class PendaftarBantuanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. KOSONGKAN TABEL & RESET ID (PENTING)
        Schema::disableForeignKeyConstraints();
        DB::table('pendaftar_bantuans')->truncate();
        Schema::enableForeignKeyConstraints();
        
        // 2. AMBIL ID DARI TABEL ACUAN
        // Pastikan nama tabel program_bantuan sudah benar di database
        $programIds = DB::table('program_bantuan')->pluck('program_id')->toArray();
        $wargaIds = Warga::pluck('warga_id')->toArray();
        
        if (empty($programIds) || empty($wargaIds)) {
            $this->command->error("Error: Tabel Program atau Warga kosong! Jalankan seeder mereka dulu.");
            return;
        }

        $statuses = ['Pending', 'Verifikasi', 'Ditolak', 'Diterima'];
        $count = 0;

        // 3. GENERATE 100 DATA PENDAFTARAN
        for ($i = 0; $i < 150; $i++) { // Loop lebih dari 100 untuk antisipasi duplikasi yang dilewati
            if ($count >= 100) break;

            $randomProgramId = $faker->randomElement($programIds);
            $randomWargaId = $faker->randomElement($wargaIds);
            $randomStatus = $faker->randomElement($statuses);

            // Cek duplikasi (Warga tidak boleh daftar program yang sama 2 kali)
            $isDuplicate = DB::table('pendaftar_bantuans')
                           ->where('program_id', $randomProgramId)
                           ->where('warga_id', $randomWargaId)
                           ->exists();

            if (!$isDuplicate) {
                DB::table('pendaftar_bantuans')->insert([
                    'program_id'     => $randomProgramId,
                    'warga_id'       => $randomWargaId,
                    'tanggal_daftar' => $faker->dateTimeBetween('-1 year', 'now'), 
                    'status_seleksi' => $randomStatus, // Kolom sesuai database Anda
                    'keterangan'     => ($randomStatus === 'Ditolak') 
                                         ? $faker->sentence(5) 
                                         : 'Dokumen lengkap', 
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
                $count++;
            }
        }

        $this->command->info("Berhasil mengisi $count data ke tabel pendaftar_bantuans (ID dimulai dari 1).");
    }
}