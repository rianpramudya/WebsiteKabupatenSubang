<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('laporan_keuangans')->insert([
            // === TAHUN 2025 (3 laporan) ===
            [
                'tenant_id' => null,
                'tahun' => 2025,
                'judul_laporan' => 'Laporan Realisasi APBD Semester I',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester pertama tahun 2025.',
                'file_url' => '/storage/laporan/apbd_semester1_2025.pdf',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'tenant_id' => null,
                'tahun' => 2025,
                'judul_laporan' => 'Laporan Realisasi APBD Semester II',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester kedua tahun 2025.',
                'file_url' => '/storage/laporan/apbd_semester2_2025.pdf',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'tenant_id' => null,
                'tahun' => 2025,
                'judul_laporan' => 'Laporan Pertanggungjawaban APBD 2024',
                'jenis_laporan' => 'Pertanggungjawaban',
                'deskripsi_singkat' => 'Pertanggungjawaban penggunaan anggaran tahun 2024.',
                'file_url' => '/storage/laporan/lpj_2024.pdf',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],

            // === TAHUN 2024 (2 laporan) ===
            [
                'tenant_id' => null,
                'tahun' => 2024,
                'judul_laporan' => 'Laporan Realisasi APBD Semester I',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester I tahun 2024.',
                'file_url' => '/storage/laporan/apbd_semester1_2024.pdf',
                'created_at' => now()->subMonths(6),
                'updated_at' => now()->subMonths(6),
            ],
            [
                'tenant_id' => null,
                'tahun' => 2024,
                'judul_laporan' => 'Laporan Realisasi APBD Semester II',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester II tahun 2024.',
                'file_url' => '/storage/laporan/apbd_semester2_2024.pdf',
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subMonths(4),
            ],

            // === TAHUN 2023 (4 laporan) ===
            [
                'tenant_id' => null,
                'tahun' => 2023,
                'judul_laporan' => 'Laporan Realisasi APBD Semester I',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester I tahun 2023.',
                'file_url' => '/storage/laporan/apbd_semester1_2023.pdf',
                'created_at' => now()->subYears(1)->subMonths(6),
                'updated_at' => now()->subYears(1)->subMonths(6),
            ],
            [
                'tenant_id' => null,
                'tahun' => 2023,
                'judul_laporan' => 'Laporan Realisasi APBD Semester II',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester II tahun 2023.',
                'file_url' => '/storage/laporan/apbd_semester2_2023.pdf',
                'created_at' => now()->subYears(1)->subMonths(4),
                'updated_at' => now()->subYears(1)->subMonths(4),
            ],
            [
                'tenant_id' => null,
                'tahun' => 2023,
                'judul_laporan' => 'Laporan Pertanggungjawaban APBD 2022',
                'jenis_laporan' => 'Pertanggungjawaban',
                'deskripsi_singkat' => 'LPJ APBD tahun anggaran 2022.',
                'file_url' => '/storage/laporan/lpj_2022.pdf',
                'created_at' => now()->subYears(1)->subMonths(2),
                'updated_at' => now()->subYears(1)->subMonths(2),
            ],
            [
                'tenant_id' => null,
                'tahun' => 2023,
                'judul_laporan' => 'Laporan Pendapatan dan Belanja Tahunan',
                'jenis_laporan' => 'Pendapatan & Belanja',
                'deskripsi_singkat' => 'Ringkasan pendapatan dan belanja APBD tahun 2023.',
                'file_url' => '/storage/laporan/ringkasan_apbd_2023.pdf',
                'created_at' => now()->subYears(1)->subMonth(),
                'updated_at' => now()->subYears(1)->subMonth(),
            ],

            // === TAHUN 2022 (1 laporan) ===
            [
                'tenant_id' => null,
                'tahun' => 2022,
                'judul_laporan' => 'Laporan Realisasi APBD Semester II',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester II tahun 2022.',
                'file_url' => '/storage/laporan/apbd_semester2_2022.pdf',
                'created_at' => now()->subYears(2),
                'updated_at' => now()->subYears(2),
            ],
        ]);
    }
}
