<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RiwayatPenyaluranBantuanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil data dari tabel yang sudah ada
        $penerimas = DB::table('penerima_bantuans')->get();
        
        if ($penerimas->isEmpty()) {
            return;
        }

        foreach ($penerimas as $penerima) {
            DB::table('riwayat_penyaluran_bantuans')->insert([
                'program_id'  => $penerima->program_id,
                'penerima_id' => $penerima->penerima_id,
                'tahap_ke'    => $faker->numberBetween(1, 4),
                'tanggal'     => $faker->dateTimeBetween('-6 months', 'now'),
                'nilai'       => $faker->randomElement([300000, 600000, 1000000]),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}