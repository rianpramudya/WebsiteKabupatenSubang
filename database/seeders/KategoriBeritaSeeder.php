<?php

namespace Database\Seeders;

use App\Models\KategoriBerita;
use Illuminate\Database\Seeder;

class KategoriBeritaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Pemerintahan', 'slug' => 'pemerintahan'],
            ['nama' => 'Sosial', 'slug' => 'sosial'],
            ['nama' => 'Ekonomi', 'slug' => 'ekonomi'],
            ['nama' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['nama' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['nama' => 'Budaya dan Wisata', 'slug' => 'budaya-wisata'],
        ];

        foreach ($data as $item) {
            KategoriBerita::firstOrCreate(
                ['slug' => $item['slug']],
                ['nama' => $item['nama']]
            );
        }
    }
}