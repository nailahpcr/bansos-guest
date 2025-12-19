<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerimaBantuanSeeder extends Seeder
{
    public function run()
    {
        $data = []; // Siapkan wadah array

        // Loop 100 kali untuk menyusun data
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'created_at' => now(),
                'updated_at' => now(),
                // 'pendaftar_id' => 1, // Uncomment & sesuaikan jika sudah ada kolom relasi
            ];
        }

        // Eksekusi insert 100 data sekaligus dalam 1 query
        DB::table('penerima_bantuan')->insert($data);
    }
}