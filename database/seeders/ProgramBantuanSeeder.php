<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProgramBantuanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Daftar 10 Program Bantuan Utama
        $programs = [
            ['nama' => 'Program Keluarga Harapan', 'kode' => 'PKH', 'desc' => 'Akses kesehatan dan pendidikan bagi keluarga miskin.'],
            ['nama' => 'Bantuan Pangan Non Tunai', 'kode' => 'BPNT', 'desc' => 'Bantuan pangan non-tunai melalui akun elektronik.'],
            ['nama' => 'Bantuan Langsung Tunai BBM', 'kode' => 'BLT-BBM', 'desc' => 'Kompensasi penyesuaian harga bahan bakar minyak.'],
            ['nama' => 'Bantuan Sosial Tunai', 'kode' => 'BST', 'desc' => 'Bantuan tunai bagi keluarga rentan ekonomi.'],
            ['nama' => 'Program Indonesia Pintar', 'kode' => 'PIP', 'desc' => 'Bantuan biaya pendidikan bagi siswa kurang mampu.'],
            ['nama' => 'Bantuan Iuran Jaminan Kesehatan', 'kode' => 'PBI-JK', 'desc' => 'Jaminan kesehatan gratis yang dibayarkan pemerintah.'],
            ['nama' => 'Bansos Sembako Adaptif', 'kode' => 'BSA', 'desc' => 'Bantuan sembako untuk respon kondisi darurat.'],
            ['nama' => 'Bantuan Modal Usaha Mikro', 'kode' => 'BMUM', 'desc' => 'Pemberian modal untuk penguatan pelaku usaha mikro.'],
            ['nama' => 'Bantuan Rehabilitasi Rumah', 'kode' => 'RTLH', 'desc' => 'Bantuan perbaikan rumah tidak layak huni bagi warga miskin.'],
            ['nama' => 'Subsidi Energi Listrik', 'kode' => 'SEL', 'desc' => 'Subsidi biaya pemakaian listrik untuk rumah tangga daya rendah.']
        ];

        for ($i = 0; $i < 100; $i++) {
            // Mengambil satu program secara acak dari 10 daftar di atas
            $p = $faker->randomElement($programs);

            DB::table('program_bantuan')->insert([
                // Kode unik: PKH-2025-123
                'kode'          => $p['kode'] . '-' . $faker->numberBetween(2020, 2025) . '-' . $faker->unique(true)->numberBetween(100, 999),
                'nama_program'  => $p['nama'],
                'tahun'         => $faker->numberBetween(2020, 2025), // Membedakan tahun
                'deskripsi'     => $p['desc'], // Keterangan singkat spesifik
                'anggaran'      => $faker->numberBetween(1000000000, 5000000000),
                'file'          => null, // Sesuai struktur DB Anda yang mengizinkan NULL
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}