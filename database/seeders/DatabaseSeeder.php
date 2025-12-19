<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // --- LEVEL 1: DATA MASTER (Harus duluan) ---
            UserSeeder::class,           // Jika ada
            WargaSeeder::class,          // Jika ada (Pendaftar butuh ini)
            ProgramBantuanSeeder::class, // (Master Data Program)

            // --- LEVEL 2: TRANSAKSI AWAL ---
            PendaftarBantuanSeeder::class, // (Menghubungkan Warga & Program)

            // --- LEVEL 3: PROSES LANJUTAN (Butuh Pendaftar) ---
            VerifikasiLapanganSeeder::class, 
            PenerimaBantuanSeeder::class,    

            // --- LEVEL 4: HASIL AKHIR (Butuh Penerima & Program) ---
        ]);
    }
}