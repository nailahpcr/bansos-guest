<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Buat 100 data user dummy
        for ($i = 0; $i < 100; $i++) {
            User::create([
                'name' => $faker->name,
                // Pastikan email unik dan menggunakan format dummy yang jelas
                'email' => 'user' . $i . '_' . $faker->unique()->randomNumber(4) . '@dummy.com',
                // Password default untuk semua user dummy
                'password' => Hash::make('password123'), 
                'email_verified_at' => now(), // Anggap sudah terverifikasi
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}