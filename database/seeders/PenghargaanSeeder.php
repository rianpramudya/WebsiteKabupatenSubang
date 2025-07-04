<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenghargaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Hapus data lama jika ada, untuk menghindari duplikasi saat seeding ulang.
        DB::table('penghargaans')->delete();

        // Masukkan data contoh ke dalam tabel 'penghargaans' untuk Kabupaten Subang
        DB::table('penghargaans')->insert([
            [
                'tenant_id' => null, // Penghargaan untuk tingkat Kabupaten Subang
                'nama_penghargaan' => 'Sertifikat Adipura Kategori Kota Kecil',
                'tahun' => '2023',
                'tingkat' => 'Nasional',
                'instansi_pemberi' => 'Kementerian Lingkungan Hidup dan Kehutanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1, // Asumsi tenant_id 1 adalah untuk Kecamatan Binong
                'nama_penghargaan' => 'Juara 1 Lomba Desa Tingkat Kabupaten',
                'tahun' => '2022',
                'tingkat' => 'Kabupaten',
                'instansi_pemberi' => 'DPMD Kabupaten Subang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 2, // Asumsi tenant_id 2 adalah untuk Kecamatan Pagaden
                'nama_penghargaan' => 'Kecamatan dengan Realisasi PBB-P2 Tertinggi',
                'tahun' => '2023',
                'tingkat' => 'Kabupaten',
                'instansi_pemberi' => 'Badan Pendapatan Daerah Kabupaten Subang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null, // Penghargaan lain untuk tingkat Kabupaten Subang
                'nama_penghargaan' => 'Penghargaan Kabupaten Layak Anak (KLA) Tingkat Pratama',
                'tahun' => '2023',
                'tingkat' => 'Nasional',
                'instansi_pemberi' => 'Kementerian Pemberdayaan Perempuan dan Perlindungan Anak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'tenant_id' => 1, // Penghargaan lain untuk Kecamatan Binong
                'nama_penghargaan' => 'Inovasi Pelayanan Administrasi Kependudukan Terbaik',
                'tahun' => '2021',
                'tingkat' => 'Kabupaten',
                'instansi_pemberi' => 'Dinas Kependudukan dan Pencatatan Sipil Kab. Subang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
