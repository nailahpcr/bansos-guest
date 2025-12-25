<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateFirstUser extends Seeder
{
    
    public function run(): void
    {
     // 1. Membuat Admin Pertama
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'], // Kunci pencarian berdasarkan email
            [
                'name'       => 'Admin',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $wargas = DB::table('warga')->get();

        foreach ($wargas as $warga) {
            DB::table('users')->updateOrInsert(
                ['email' => $warga->email],
                [
                    'name'              => $warga->nama,
                    'password'          => $warga->password, // Password sama dengan di tabel warga
                    'role'              => 'user',
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]
            );
        }
    }
}