<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Galeri;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengosongkan tabel sebelum seeding untuk menghindari duplikasi
        DB::table('galeris')->delete();

        // Mengambil data kecamatan berdasarkan ID untuk relasi
        $binong = Kecamatan::find(2);
        $blanakan = Kecamatan::find(3);

        if ($binong) {
            Galeri::create([
                'kecamatan_id' => $binong->id, 
                'judul' => 'Suasana Pasar Pagi Binong', 
                'tipe' => 'foto', 
                'file_url' => 'galeri/binong_pasar.jpg'
            ]);
            Galeri::create([
                'kecamatan_id' => $binong->id, 
                'judul' => 'Keindahan Persawahan Hijau', 
                'tipe' => 'foto', 
                'file_url' => 'galeri/binong_sawah.jpg'
            ]);
            Galeri::create([
                'kecamatan_id' => $binong->id, 
                'judul' => 'Dokumentasi Festival Budaya Lokal', 
                'tipe' => 'video_yt', // <-- PERBAIKAN: Sesuai dengan migrasi baru
                'file_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'
            ]);
        }

        if ($blanakan) {
            Galeri::create([
                'kecamatan_id' => $blanakan->id, 
                'judul' => 'Aktivitas Nelayan di Pagi Hari', 
                'tipe' => 'foto', 
                'file_url' => 'galeri/blanakan_nelayan.jpg'
            ]);
            Galeri::create([
                'kecamatan_id' => $blanakan->id, 
                'judul' => 'Pesona Hutan Mangrove Blanakan', 
                'tipe' => 'foto', 
                'file_url' => 'galeri/blanakan_mangrove.jpg'
            ]);
            Galeri::create([
                'kecamatan_id' => $blanakan->id, 
                'judul' => 'Keindahan Pesisir Blanakan dari Udara', 
                'tipe' => 'video_yt', // <-- PERBAIKAN: Sesuai dengan migrasi baru
                'file_url' => 'https://www.youtube.com/embed/abcdef12345'
            ]);
        }
    }
}
