<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PenerimaBantuanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Mengambil pendaftar yang status_seleksinya 'lolos'
        $pendaftarLolos = DB::table('pendaftar_bantuans')
                            ->where('status_seleksi', 'diterima')
                            ->get();

        if ($pendaftarLolos->isEmpty()) {
            $this->command->warn('Tidak ada pendaftar dengan status "diterima". Pastikan PendaftarBantuanSeeder sudah dijalankan.');
            return;
        }

        foreach ($pendaftarLolos as $pendaftar) {
            DB::table('penerima_bantuans')->insert([
                // Sesuai skema: penerima_id (PK), program_id (FK), warga_id (FK), keterangan
                'program_id' => $pendaftar->program_id,
                'warga_id'   => $pendaftar->warga_id,
                'keterangan' => $faker->randomElement([
                    'Layak menerima bantuan berdasarkan verifikasi ekonomi.',
                    'Memenuhi kriteria keluarga penerima manfaat (KPM).',
                    'Terdaftar sebagai penerima bantuan periode reguler.',
                    'Data sesuai dengan DTKS (Data Terpadu Kesejahteraan Sosial).'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Berhasil menambahkan data ke tabel penerima_bantuan.');
    }
}