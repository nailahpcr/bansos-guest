<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Tambahkan ini untuk helper string jika perlu

class WargaDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 100; $i++) {
            $ktp = $faker->unique()->numerify('################'); 
            $nama = $faker->name;

            // Mengambil kata pertama dari nama
            // explode memecah nama, reset mengambil elemen pertama
            $kataPertama = strtolower(explode(' ', trim($nama))[0]);
            
            // Membuat email unik dengan tambahan angka random/ktp agar tidak bentrok
            $email = $kataPertama . $faker->unique()->numberBetween(1, 999) . '@example.com';

            DB::table('warga')->insert([
                'no_ktp'            => $ktp,
                'nama'              => $nama,
                'email'             => $email,
                'email_verified_at' => now(),
                'password'          => Hash::make('warga_' . substr($ktp, -4)),
                'jenis_kelamin'     => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'             => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu']),
                'pekerjaan'         => $faker->jobTitle,
                'telp'              => $faker->numerify('08##########'),
                'updated_at'        => now(),
                'created_at'        => now(), // Sebaiknya tambahkan created_at juga
            ]);
        }
    }
}