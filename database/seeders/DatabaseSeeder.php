<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WargaDummy::class,
            CreateFirstUser::class,
            ProgramBantuanSeeder::class,
            PendaftarBantuanSeeder::class,
            VerifikasiLapanganSeeder::class,
            PenerimaBantuanSeeder::class,
            RiwayatPenyaluranBantuanSeeder::class,
            ]);
    }
}