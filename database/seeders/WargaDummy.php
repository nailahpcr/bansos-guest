<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WargaDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 100; $i++) {
            $ktp = $faker->unique()->numerify('################'); // 16 digit KTP
            
            DB::table('warga')->insert([
                'no_ktp'         => $ktp,
                'nama'           => $faker->name,
                'email'          => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                // Password unik: "warga_" diikuti 4 digit terakhir KTP
                'password'       => Hash::make('warga_' . substr($ktp, -4)), 
                'jenis_kelamin'  => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'          => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu']),
                'pekerjaan'      => $faker->jobTitle,
                'telp' => $faker->phoneNumber,
                'updated_at'     => now(),
            ]);
        }
    }
}