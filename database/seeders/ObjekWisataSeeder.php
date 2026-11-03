<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ObjekWisata;
use App\Models\Kecamatan;
use Illuminate\Support\Str;

class ObjekWisataSeeder extends Seeder
{
    public function run(): void
    {

        ObjekWisata::create([
            'kecamatan_id' => null,
            'nama' => 'Pemandian Air Panas Sari Ater',
            'slug' => Str::slug('Pemandian Air Panas Sari Ater'),
            'kategori' => 'Alam',
            'deskripsi_singkat' => 'Nikmati relaksasi di sumber air panas alami dengan pemandangan pegunungan yang indah.',
            'lokasi_teks' => 'Ciater, Subang',
            'is_unggulan' => true,
        ]);

        $kecamatanPagaden = Kecamatan::where('slug', 'pagaden')->first();
        if ($kecamatanPagaden) {
            ObjekWisata::create([
                'kecamatan_id' => $kecamatanPagaden->id,
                'nama' => 'Situ Cigayonggong',
                'slug' => Str::slug('Situ Cigayonggong'),
                'kategori' => 'Alam',
                'deskripsi_singkat' => 'Danau buatan yang asri, cocok untuk bersantai bersama keluarga di akhir pekan.',
                'lokasi_teks' => 'Pagaden, Subang',
            ]);
        }
    }
}
