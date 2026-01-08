<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateFirstUser extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Admin Utama
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'], 
            [
                'name'       => 'Admin Sistem',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Mengambil data dari tabel warga
        $wargas = DB::table('warga')->get();

        foreach ($wargas as $warga) {
            DB::table('users')->updateOrInsert(
                ['email' => $warga->email], 
                [
                    'name'              => $warga->nama,
                    'password'          => $warga->password, 
                    'role'              => 'user',
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]
            );
        }
    }
}