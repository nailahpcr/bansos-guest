<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class VerifikasiLapanganSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // 1. RESET TABEL
        Schema::disableForeignKeyConstraints();
        DB::table('verifikasi_lapangans')->truncate();
        Schema::enableForeignKeyConstraints();

        $daftarPetugas = ['Budi', 'Siti', 'Agus', 'Putri', 'Hendra'];

        // 2. AMBIL DATA PENDAFTAR
        $pendaftar = DB::table('pendaftar_bantuans')->get();

        if ($pendaftar->isEmpty()) {
            $this->command->error('Tabel pendaftar_bantuans kosong!');
            return;
        }

        $data = [];
        foreach ($pendaftar as $p) {
            // Kita buat verifikasi untuk hampir semua pendaftar agar index tidak kosong
            if ($faker->boolean(100)) {
                
                // Menentukan skor (Acak antara 50 - 95)
                $skor = $faker->numberBetween(50, 95);
                
                // 3. LOGIKA CATATAN BERDASARKAN AMBANG BATAS SKOR LAYAK (70)
                $catatan = $this->getCatatanBerdasarkanSkor($skor);

                $data[] = [
                    'pendaftar_id' => $p->pendaftar_id,
                    'petugas'      => $faker->randomElement($daftarPetugas), 
                    'tanggal'      => $faker->dateTimeBetween('-1 month', 'now'),
                    'catatan'      => $catatan,
                    'skor'         => $skor,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }
        }

        DB::table('verifikasi_lapangans')->insert($data);
        $this->command->info('Berhasil membuat data verifikasi yang selaras dengan filter skor (70).');
    }

    /**
     * Catatan disesuaikan dengan ambang batas skor 70 (Layak/Kurang)
     */
    private function getCatatanBerdasarkanSkor($skor)
    {
        // KATEGORI SKOR LAYAK (>= 70)
        if ($skor >= 70) {
            $opsi = [
                'Subjek sangat memenuhi kriteria, kondisi hunian memprihatinkan.',
                'Penghasilan jauh di bawah rata-rata, layak diprioritaskan.',
                'Aset pendukung tidak ditemukan, subjek masuk kategori sangat layak.',
                'Hasil survei menunjukkan subjek benar-benar membutuhkan bantuan ini.'
            ];
            return $opsi[array_rand($opsi)];
        } 
        
        // KATEGORI SKOR KURANG (< 70)
        else {
            $opsi = [
                'Kondisi ekonomi subjek dinilai cukup mampu di lingkungan sekitar.',
                'Subjek memiliki pekerjaan tetap dengan penghasilan stabil.',
                'Kepemilikan aset (kendaraan/elektronik) melebihi standar penerima.',
                'Hunian dalam kondisi baik/permanen, skor kelayakan rendah.'
            ];
            return $opsi[array_rand($opsi)];
        }
    }
}