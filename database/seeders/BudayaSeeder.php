<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Budaya;
use App\Models\Kecamatan;
use Illuminate\Support\Str;

class BudayaSeeder extends Seeder
{
    public function run(): void
    {

        $budayasKabupaten = [
            'Sisingaan', 'Genjring Bonyok', 'Doger Subang', 'Ruwatan Bumi', 'Gembyung'
        ];

        foreach($budayasKabupaten as $nama) {
            Budaya::updateOrCreate(
                ['slug' => Str::slug($nama)],
                [
                    'kecamatan_id' => null,
                    'nama' => $nama,
                    'deskripsi' => "Deskripsi lengkap untuk kesenian $nama akan ditampilkan di sini. Kesenian ini merupakan warisan budaya takbenda yang kaya akan nilai historis dan filosofis dari masyarakat Subang.",
                    'gambar' => null,
                    'published_at' => now(),
                ]
            );
        }

        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();

        if ($kecamatanBinong) {
            $budayasBinong = [
                'Terbang Gebes' => 'Kesenian musik religi yang khas dari Binong, sering ditampilkan dalam acara keagamaan dan hajatan.',
                'Kuda Renggong Khas Binong' => 'Versi lokal dari Kuda Renggong dengan irama dan gerakan yang memiliki ciri khas tersendiri dari wilayah Binong.'
            ];

            foreach($budayasBinong as $nama => $deskripsi) {
                Budaya::updateOrCreate(
                    ['slug' => Str::slug($nama)],
                    [
                        'kecamatan_id' => $kecamatanBinong->id,
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
