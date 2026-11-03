<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Infografis;
use App\Models\Kecamatan;
use Illuminate\Support\Str;

class InfografisSeeder extends Seeder
{
    public function run(): void
    {

        Infografis::create([
            'kecamatan_id' => null,
            'judul' => 'Alur Pelayanan Publik Kabupaten Subang',
            'slug' => Str::slug('Alur Pelayanan Publik Kabupaten Subang'),
            'deskripsi' => 'Infografis mengenai alur pelayanan publik terpadu di tingkat kabupaten.',
            'gambar' => 'infografis/kabupaten-1.jpg',
            'published_at' => now(),
        ]);

        $kecamatanCibogo = Kecamatan::where('slug', 'cibogo')->first();
        if ($kecamatanCibogo) {
            Infografis::create([
                'kecamatan_id' => $kecamatanCibogo->id,
                'judul' => 'Jadwal Pelayanan Kecamatan Cibogo',
                'slug' => Str::slug('Jadwal Pelayanan Kecamatan Cibogo'),
                'deskripsi' => 'Jadwal lengkap jam operasional pelayanan administrasi di Kantor Kecamatan Cibogo.',
                'gambar' => 'infografis/cibogo-1.jpg',
                'published_at' => now(),
            ]);
        }
    }
}
