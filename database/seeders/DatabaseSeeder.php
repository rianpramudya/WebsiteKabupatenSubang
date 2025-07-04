<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            KecamatanSeeder::class,
            KategoriBeritaSeeder::class,
            BeritaSeeder::class,
            LaporanKeuanganSeeder::class,
            PerangkatDaerahSeeder::class,
            BudayaSeeder::class,
            ObjekWisataSeeder::class,
            SejarahSeeder::class,
            PeranDanProgramSeeder::class,
            InfografisSeeder::class,
            HotelSeeder::class,
            VisiMisiSeeder::class,
            RumahMakanSeeder::class,
            PenghargaanSeeder::class,
            PejabatSeeder::class,
        ]);
    }
}
