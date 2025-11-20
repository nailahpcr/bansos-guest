<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftar;
use App\Models\ProgramBantuan; 
use App\Models\Warga;
use Faker\Factory as Faker;

class PendaftarDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $programIds = ProgramBantuan::pluck('program_id')->toArray();
        $wargaIds = Warga::pluck('warga_id')->toArray();
        
        if (empty($programIds) || empty($wargaIds)) {
            echo "Error: Pastikan ProgramBantuanSeeder dan WargaDummy sudah dijalankan dan memiliki data.\n";
            return;
        }

        $statuses = ['Pending', 'Verifikasi', 'Ditolak'];
        
        for ($i = 0; $i < 50; $i++) {
            
            $randomProgramId = $faker->randomElement($programIds);
            $randomWargaId = $faker->randomElement($wargaIds);
            $randomStatus = $faker->randomElement($statuses);

            $isDuplicate = DB::table('pendaftar_bantuan')
                           ->where('program_id', $randomProgramId)
                           ->where('warga_id', $randomWargaId)
                           ->exists();

            if ($isDuplicate) {
                continue; 
            }
            
            DB::table('pendaftar_bantuan')->insert([
                'program_id' => $randomProgramId,
                'warga_id' => $randomWargaId,
                'tanggal_daftar' => $faker->dateTimeBetween('-1 year', 'now'), 
                'status' => $randomStatus,
                'keterangan' => ($randomStatus === 'Ditolak') 
                                ? $faker->sentence(5) 
                                : null, 
                
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}