<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RiwayatPenyaluranSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil ID Program dan ID Penerima yang tersedia
        $programIds = DB::table('program_bantuan')->pluck('program_id')->toArray();
        $penerimaIds = DB::table('penerima_bantuan')->pluck('id')->toArray();

        // Cek ketersediaan data relasi
        if (empty($programIds) || empty($penerimaIds)) {
            $this->command->info('Data Program atau Penerima kosong. Harap isi dulu.');
            return;
        }

        $data = []; // Array penampung data

        // Loop 100 kali
        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'program_id'         => $faker->randomElement($programIds),
                'penerima_id'        => $faker->randomElement($penerimaIds),
                'tahap_ke'           => 'Tahap ' . $faker->numberBetween(1, 3),
                'tanggal_penyaluran' => $faker->dateTimeBetween('-3 months', 'now'),
                'nilai_bantuan'      => $faker->randomElement([300000, 600000, 1200000]),
                'bukti_penyaluran'   => 'bukti_dummy_' . $i . '.jpg', // Menggunakan index loop agar nama file unik
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        // Eksekusi insert 100 data sekaligus (1 Query)
        DB::table('riwayat_penyalurans')->insert($data);
    }
}