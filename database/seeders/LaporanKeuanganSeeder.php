<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;

class LaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('laporan_keuangans')->delete();

        $laporanKabupaten = [

            [
                'tahun' => 2025,
                'judul_laporan' => 'Laporan Realisasi APBD Semester I',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester pertama tahun 2025.',
                'file_url' => '/storage/laporan/apbd_semester1_2025.pdf',
            ],
            [
                'tahun' => 2025,
                'judul_laporan' => 'Laporan Realisasi APBD Semester II',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester kedua tahun 2025.',
                'file_url' => '/storage/laporan/apbd_semester2_2025.pdf',
            ],
            [
                'tahun' => 2025,
                'judul_laporan' => 'Laporan Pertanggungjawaban APBD 2024',
                'jenis_laporan' => 'Pertanggungjawaban',
                'deskripsi_singkat' => 'Pertanggungjawaban penggunaan anggaran tahun 2024.',
                'file_url' => '/storage/laporan/lpj_2024.pdf',
            ],

            [
                'tahun' => 2022,
                'judul_laporan' => 'Laporan Realisasi APBD Semester II',
                'jenis_laporan' => 'Realisasi Anggaran',
                'deskripsi_singkat' => 'Realisasi anggaran semester II tahun 2022.',
                'file_url' => '/storage/laporan/apbd_semester2_2022.pdf',
            ],
        ];

        foreach ($laporanKabupaten as $laporan) {
            DB::table('laporan_keuangans')->insert([
                'kecamatan_id' => null,
                'perangkat_daerah_id' => null,
                'tahun' => $laporan['tahun'],
                'judul_laporan' => $laporan['judul_laporan'],
                'jenis_laporan' => $laporan['jenis_laporan'],
                'deskripsi_singkat' => $laporan['deskripsi_singkat'],
                'file_url' => $laporan['file_url'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();
        if ($kecamatanBinong) {
            DB::table('laporan_keuangans')->insert([
                'kecamatan_id' => $kecamatanBinong->id,
                'perangkat_daerah_id' => null,
                'tahun' => 2024,
                'judul_laporan' => 'Laporan Dana Desa Kecamatan Binong',
                'jenis_laporan' => 'Alokasi Dana Desa',
                'deskripsi_singkat' => 'Laporan penggunaan alokasi dana desa untuk pembangunan di Kecamatan Binong.',
                'file_url' => '/storage/laporan/dd_binong_2024.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
