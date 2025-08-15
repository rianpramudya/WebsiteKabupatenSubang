<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            // 1. Data Master Utama (dijalankan pertama)
            KecamatanSeeder::class,
            PerangkatDaerahSeeder::class,
            KategoriBeritaSeeder::class,

            // 2. Hak Akses (Role & Permission)
            RoleAndPermissionSeeder::class,

            // 3. Pengguna (bergantung pada Role dan Data Master)
            UserSeeder::class,

            // 4. Konten (bergantung pada Data Master)
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
            SejarahSeeder::class, // Seeder untuk timeline sejarah
        ]);
    }
}