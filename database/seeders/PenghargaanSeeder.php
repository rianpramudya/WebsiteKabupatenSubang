<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;

class PenghargaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penghargaans')->delete();

        $binong = Kecamatan::where('slug', 'binong')->first();
        $disdukcapil = PerangkatDaerah::where('slug', 'disdukcapil')->first();

        $penghargaans = [
            // Penghargaan Tingkat Kabupaten (tidak terikat tenant)
            [
                'kecamatan_id' => null,
                'perangkat_daerah_id' => null,
                'nama_penghargaan' => 'Sertifikat Adipura Kategori Kota Kecil',
                'tahun' => 2023,
                'tingkat' => 'Nasional',
                'instansi_pemberi' => 'Kementerian Lingkungan Hidup dan Kehutanan',
            ],
            [
                'kecamatan_id' => null,
                'perangkat_daerah_id' => null,
                'nama_penghargaan' => 'Penghargaan Kabupaten Layak Anak (KLA) Tingkat Pratama',
                'tahun' => 2023,
                'tingkat' => 'Nasional',
                'instansi_pemberi' => 'Kementerian Pemberdayaan Perempuan dan Perlindungan Anak',
            ],

            // Penghargaan spesifik untuk Kecamatan Binong
            [
                'kecamatan_id' => $binong->id ?? null,
                'perangkat_daerah_id' => null,
                'nama_penghargaan' => 'Juara 1 Lomba Desa Tingkat Kabupaten',
                'tahun' => 2022,
                'tingkat' => 'Kabupaten',
                'instansi_pemberi' => 'DPMD Kabupaten Subang',
            ],

            // Penghargaan spesifik untuk Perangkat Daerah Disdukcapil
            [
                'kecamatan_id' => null,
                'perangkat_daerah_id' => $disdukcapil->id ?? null,
                'nama_penghargaan' => 'Inovasi Pelayanan Administrasi Kependudukan Terbaik',
                'tahun' => 2021,
                'tingkat' => 'Kabupaten',
                'instansi_pemberi' => 'Dinas Kependudukan dan Pencatatan Sipil Kab. Subang',
            ],
        ];

        // Masukkan semua data ke database
        foreach ($penghargaans as $penghargaan) {
            DB::table('penghargaans')->insert([
                'kecamatan_id' => $penghargaan['kecamatan_id'],
                'perangkat_daerah_id' => $penghargaan['perangkat_daerah_id'],
                'nama_penghargaan' => $penghargaan['nama_penghargaan'],
                'tahun' => $penghargaan['tahun'],
                'tingkat' => $penghargaan['tingkat'],
                'instansi_pemberi' => $penghargaan['instansi_pemberi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
