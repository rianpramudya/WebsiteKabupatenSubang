<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RumahMakan;
use App\Models\Kecamatan;
use Illuminate\Support\Str;

class RumahMakanSeeder extends Seeder
{
    public function run(): void
    {
        // Data untuk Kabupaten
        RumahMakan::create([
            'kecamatan_id' => null,
            'nama' => 'RM Ibu Hj. Ciganea',
            'slug' => Str::slug('RM Ibu Hj Ciganea'),
            'jenis_kuliner' => 'Sunda',
            'deskripsi' => 'Menyajikan masakan khas Sunda otentik dengan sambal dadak yang legendaris.',
            'alamat' => 'Jl. Raya Cipeundeuy, Subang',
            'published_at' => now(),
        ]);

        // Data untuk Kecamatan Cibogo
        $kecamatanCibogo = Kecamatan::where('slug', 'cibogo')->first();
        if ($kecamatanCibogo) {
            RumahMakan::create([
                'kecamatan_id' => $kecamatanCibogo->id,
                'nama' => 'Baso Rudal Cibogo',
                'slug' => Str::slug('Baso Rudal Cibogo'),
                'jenis_kuliner' => 'Bakso',
                'deskripsi' => 'Warung bakso populer dengan ukuran jumbo dan rasa kaldu yang kaya rempah.',
                'alamat' => 'Jl. Cibogo, Subang',
                'published_at' => now(),
            ]);
        }
    }
}
