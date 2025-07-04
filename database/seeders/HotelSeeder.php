<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Kecamatan;
use Illuminate\Support\Str;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // Data untuk Kabupaten
        Hotel::create([
            'kecamatan_id' => null,
            'nama' => 'Laska Hotel Subang',
            'slug' => Str::slug('Laska Hotel Subang'),
            'bintang' => 4,
            'deskripsi' => 'Hotel modern dengan fasilitas lengkap, cocok untuk bisnis dan liburan keluarga.',
            'alamat' => 'Jl. Letjend S. Parman No.59, Subang',
            'published_at' => now(),
        ]);

        // Data untuk Kecamatan Cibogo
        $kecamatanCibogo = Kecamatan::where('slug', 'cibogo')->first();
        if ($kecamatanCibogo) {
            Hotel::create([
                'kecamatan_id' => $kecamatanCibogo->id,
                'nama' => 'Penginapan Asri Cibogo',
                'slug' => Str::slug('Penginapan Asri Cibogo'),
                'bintang' => 2,
                'deskripsi' => 'Akomodasi sederhana dan bersih dengan suasana pedesaan yang tenang.',
                'alamat' => 'Jl. Raya Cibogo, Subang',
                'published_at' => now(),
            ]);
        }
    }
}
