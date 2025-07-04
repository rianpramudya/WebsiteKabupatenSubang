<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Budaya;
use App\Models\Kecamatan; // Diperlukan untuk mencari ID kecamatan
use Illuminate\Support\Str;

class BudayaSeeder extends Seeder
{
    public function run(): void
    {
        // Data untuk Tingkat Kabupaten
        $budayasKabupaten = [
            'Sisingaan', 'Genjring Bonyok', 'Doger Subang', 'Ruwatan Bumi', 'Gembyung'
        ];

        foreach($budayasKabupaten as $nama) {
            Budaya::updateOrCreate(
                ['slug' => Str::slug($nama)],
                [
                    'kecamatan_id' => null, // Milik Kabupaten
                    'nama' => $nama,
                    'deskripsi' => "Deskripsi lengkap untuk kesenian $nama akan ditampilkan di sini. Kesenian ini merupakan warisan budaya takbenda yang kaya akan nilai historis dan filosofis dari masyarakat Subang.",
                    'gambar' => null,
                    'published_at' => now(),
                ]
            );
        }

        // --- DATA BARU UNTUK KECAMATAN BINONG ---
        // 1. Cari dulu data Kecamatan Binong untuk mendapatkan ID-nya
        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();

        // 2. Jika data Kecamatan Binong ditemukan, buat data budaya yang berelasi dengannya
        if ($kecamatanBinong) {
            $budayasBinong = [
                'Terbang Gebes' => 'Kesenian musik religi yang khas dari Binong, sering ditampilkan dalam acara keagamaan dan hajatan.',
                'Kuda Renggong Khas Binong' => 'Versi lokal dari Kuda Renggong dengan irama dan gerakan yang memiliki ciri khas tersendiri dari wilayah Binong.'
            ];

            foreach($budayasBinong as $nama => $deskripsi) {
                Budaya::updateOrCreate(
                    ['slug' => Str::slug($nama)],
                    [
                        'kecamatan_id' => $kecamatanBinong->id, // ID Kecamatan Binong
                        'nama' => $nama,
                        'deskripsi' => $deskripsi,
                        'gambar' => null,
                        'published_at' => now(),
                    ]
                );
            }
        }
    }
}
