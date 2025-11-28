<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class WargaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 100; $i++) { 
            
            $jenis_kelamin_faker = $faker->randomElement(['male', 'female']);
            $jenis_kelamin_db = ($jenis_kelamin_faker == 'male') ? 'Laki-laki' : 'Perempuan'; 
            
            DB::table('warga')->insert([
                'password' => Hash::make('password_dummy'),
                'no_ktp' => $faker->numerify('32##############'),  
                'nama' => $faker->name($jenis_kelamin_faker),
                'jenis_kelamin' => $jenis_kelamin_db, 
                
                'agama' => $faker->randomElement([
                    'Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'
                ]),
                
                'pekerjaan' => $faker->randomElement([
                    'Wiraswasta', 'PNS', 'Karyawan Swasta', 'Petani', 'Nelayan',
                    'Guru', 'Dokter', 'Perawat', 'Pedagang', 'Buruh', 'Mahasiswa'
                ]),
                
                'telp' => $faker->numerify('08#########'),
                
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
            ]);
        }
    }
}
   
