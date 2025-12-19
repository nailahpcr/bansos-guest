<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VerifikasiLapanganSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil semua ID dari tabel pendaftar_bantuan untuk relasi
        $pendaftarIds = DB::table('pendaftar_bantuan')->pluck('pendaftar_id')->toArray(); 

        // Jika pendaftar kosong, hentikan agar tidak error
        if (empty($pendaftarIds)) {
            $this->command->info('Tabel pendaftar_bantuan kosong. Harap isi data pendaftar dulu.');
            return;
        }

        $data = []; // Siapkan array kosong untuk menampung data

        // Loop untuk membuat 100 data dummy di memori (belum masuk database)
        for ($i = 0; $i < 100; $i++) { 
            $data[] = [
                'pendaftar_id' => $faker->randomElement($pendaftarIds),
                'petugas'      => $faker->name,
                'tanggal'      => $faker->dateTimeBetween('-1 month', 'now'),
                'catatan'      => $faker->sentence(10),
                'skor'         => $faker->numberBetween(40, 95),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        // EKSEKUSI: Insert 100 data sekaligus dalam 1 Query
        DB::table('verifikasi_lapangans')->insert($data);
    }
}