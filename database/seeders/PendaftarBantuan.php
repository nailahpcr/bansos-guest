<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramBantuan; 
use App\Models\Warga;
use Faker\Factory as Faker;

class PendaftarBantuan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil program_id dan warga_id yang sudah ada
        $programIds = ProgramBantuan::pluck('program_id')->toArray();
        $wargaIds = Warga::pluck('warga_id')->toArray();
        
        // Cek jika tabel acuan kosong (kegagalan yang paling umum)
        if (empty($programIds) || empty($wargaIds)) {
            echo "Error: Pastikan ProgramBantuan dan Warga memiliki data (Seeder terkait sudah dijalankan) sebelum menjalankan PendaftarDummy.\n";
            return;
        }

        $statuses = ['Pending', 'Verifikasi', 'Ditolak', 'Diterima'];
        
        // Ulangi untuk membuat 100 data pendaftaran
        for ($i = 0; $i < 100; $i++) {
            
            $randomProgramId = $faker->randomElement($programIds);
            $randomWargaId = $faker->randomElement($wargaIds);
            $randomStatus = $faker->randomElement($statuses);

            // Cek duplikasi untuk menghormati UNIQUE constraint di migration
            $isDuplicate = DB::table('pendaftar_bantuans')
                           ->where('program_id', $randomProgramId)
                           ->where('warga_id', $randomWargaId)
                           ->exists();

            if ($isDuplicate) {
                // Lewati iterasi jika kombinasi pendaftar dan program sudah ada
                continue; 
            }
            
            // Perintah untuk MENGISI DATA (INSERT)
            DB::table('pendaftar_bantuans')->insert([
                'program_id' => $randomProgramId,
                'warga_id' => $randomWargaId,
                'tanggal_daftar' => $faker->dateTimeBetween('-1 year', 'now'), 
                'status_seleksi' => $randomStatus,
                'keterangan' => ($randomStatus === 'Ditolak') 
                                 ? $faker->sentence(5) 
                                 : null, 
                
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}