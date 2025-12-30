<?php

namespace Database\Seeders;

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
        
        $programIds = ProgramBantuan::pluck('program_id')->toArray();
        $wargaIds = Warga::pluck('warga_id')->toArray();
        
        if (empty($programIds) || empty($wargaIds)) {
            echo "Error: Pastikan ProgramBantuan dan Warga memiliki data sebelum menjalankan Seeder ini.\n";
            return;
        }

        $statuses = ['Pending', 'Ditolak', 'Diterima'];
        
        for ($i = 0; $i < 100; $i++) {
            
            $randomProgramId = $faker->randomElement($programIds);
            $randomWargaId = $faker->randomElement($wargaIds);
            $randomStatus = $faker->randomElement($statuses);

            // Cek duplikasi
            $isDuplicate = DB::table('pendaftar_bantuans')
                           ->where('program_id', $randomProgramId)
                           ->where('warga_id', $randomWargaId)
                           ->exists();

            if ($isDuplicate) {
                continue; 
            }

            // --- LOGIC TEKS KETERANGAN ---
            $keterangan = null;

            if ($randomStatus === 'Diterima') {
                $keterangan = $faker->randomElement([
                    'Dokumen lengkap dan memenuhi kriteria kelayakan bantuan.',
                    'Lolos verifikasi faktual lapangan oleh tim desa.',
                    'Data sinkron dengan DTKS pusat dan layak menerima manfaat.',
                    'Memenuhi syarat prioritas bantuan sosial tahun ini.'
                ]);
            } elseif ($randomStatus === 'Ditolak') {
                $keterangan = $faker->randomElement([
                    'NIK tidak terdaftar dalam Data Terpadu Kesejahteraan Sosial (DTKS).',
                    'Pendapatan keluarga melebihi batas maksimal kriteria bantuan.',
                    'Terdapat ketidaksesuaian antara dokumen fisik dan data sistem.',
                ]);
            } else {
                // Status Pending
                $keterangan = 'Berkas telah diterima dan sedang dalam tahap verifikasi administrasi.';
            }
            
            DB::table('pendaftar_bantuans')->insert([
                'program_id' => $randomProgramId,
                'warga_id' => $randomWargaId,
                'tanggal_daftar' => $faker->dateTimeBetween('-1 year', 'now'), 
                'status_seleksi' => $randomStatus,
                'keterangan' => $keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}