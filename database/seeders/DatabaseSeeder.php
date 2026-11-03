<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([

            KecamatanSeeder::class,
            PerangkatDaerahSeeder::class,
            KategoriBeritaSeeder::class,

            RoleAndPermissionSeeder::class,

            UserSeeder::class,

            AgendaSeeder::class,
            BeritaSeeder::class,
            BudayaSeeder::class,
            GaleriSeeder::class,
            HotelSeeder::class,
            InfografisSeeder::class,
            LaporanKeuanganSeeder::class,
            LayananSeeder::class,
            ObjekWisataSeeder::class,
            PejabatSeeder::class,
            PenghargaanSeeder::class,
            PeranDanProgramSeeder::class,
            RumahMakanSeeder::class,
            SejarahSeeder::class,
        ]);
    }
}