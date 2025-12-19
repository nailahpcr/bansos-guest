<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Wajib import ini untuk matikan FK check
use Faker\Factory as Faker;

class ProgramBantuanSeeder extends Seeder
{
    public function run()
    {
        // ---------------------------------------------------------
        // TAHAP 1: BERSIHKAN DATA LAMA (TRUNCATE)
        // ---------------------------------------------------------
        
        // Matikan pengecekan Foreign Key agar tidak error saat hapus data induk
        Schema::disableForeignKeyConstraints();
        
        // Kosongkan tabel (Reset ID kembali ke 1)
        DB::table('program_bantuan')->truncate();
        
        // Hidupkan kembali pengecekan Foreign Key
        Schema::enableForeignKeyConstraints();

        // ---------------------------------------------------------
        // TAHAP 2: BUAT 100 DATA BARU (BATCH INSERT)
        // ---------------------------------------------------------
        
        $faker = Faker::create('id_ID');
        $data = [];

        // Daftar nama program custom agar terlihat real
        $jenisProgram = ['BLT BBM', 'PKH', 'Bantuan Sembako', 'Bantuan Lansia', 'Bantuan Disabilitas', 'Beasiswa Pendidikan', 'Bedah Rumah', 'Bantuan UMKM'];

       for ($i = 0; $i < 100; $i++) {
    // Tambahkan ->unique() sebelum ->bothify(...)
    // Ini memaksa Faker untuk mengingat dan tidak mengulang kode yang sudah dibuat
    $kodeUnik = strtoupper($faker->unique()->bothify('PRG-####'));

    $namaProgram = $faker->randomElement($jenisProgram) . ' - Batch ' . $faker->numberBetween(1, 20);
    
    $data[] = [
        'kode'         => $kodeUnik, // Gunakan variabel yang sudah dijamin unik
        'nama_program' => $namaProgram,
        'deskripsi'    => $faker->paragraph(2),
        'tahun'        => $faker->year(),
        'anggaran'     => $faker->randomElement([50000000, 100000000, 250000000, 500000000]),
        'created_at'   => now(),
        'updated_at'   => now(),
    ];
}
        // Insert sekaligus 100 data
        DB::table('program_bantuan')->insert($data);
    }
}