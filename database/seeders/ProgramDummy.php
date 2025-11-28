<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker; // Tambahkan import Faker

class ProgramDummy extends Seeder // NAMA CLASS SUDAH DIUBAH
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. NONAKTIFKAN pemeriksaan Kunci Asing sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $faker = Faker::create('id_ID'); // Inisialisasi Faker dengan lokal Indonesia
        $periode = ['Bulanan', 'Triwulanan', 'Semester', 'Satu Kali', 'Disesuaikan'];
        $tahun_mulai = 2023; // Tahun mulai dummy
        
        // Hapus data lama (sekarang bisa berjalan karena pemeriksaan FK dinonaktifkan)
        DB::table('program_bantuan')->truncate(); 
        
        // Daftar nama program yang lebih umum untuk diacak
        $program_names = [
            'Bantuan Pangan Non Tunai (BPNT)',
            'Program Keluarga Harapan (PKH)',
            'Bantuan Langsung Tunai (BLT)',
            'Beasiswa Unggulan Daerah',
            'Bantuan Modal Usaha Mikro',
            'Subsidi Kebutuhan Energi',
            'Program Kesehatan Gratis',
            'Bantuan Pendidikan Yatim Piatu',
        ];

        // Loop untuk membuat 6 data Program Bantuan
        for ($i = 1; $i <= 6; $i++) {
            DB::table('program_bantuan')->insert([
                // Kolom 'kode' harus unik
                'kode' => 'PRG-' . $faker->unique()->randomNumber(3, true), 
                
                // Menggunakan randomElement dari daftar, lalu ditambahkan kata acak agar unik
                'nama_program' => $faker->unique()->randomElement($program_names) . ' ' . $faker->randomNumber(2, false), 
                
                'deskripsi' => $faker->sentence(10), // Deskripsi acak 10 kata
            

                // Kolom 'tahun' dan 'anggaran' disesuaikan dengan kebutuhan Controller/Model
                'tahun' => $tahun_mulai + ($i % 3), // Tahun 2023-2025
                'anggaran' => $faker->numberBetween(100000000, 500000000), // Anggaran acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // 2. AKTIFKAN kembali pemeriksaan Kunci Asing
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}