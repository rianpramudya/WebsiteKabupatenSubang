<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        Berita::query()->delete();

        $kategoriPemerintahan = KategoriBerita::where('slug', 'pemerintahan')->first();
        $kategoriPendidikan = KategoriBerita::where('slug', 'pendidikan')->first();
        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();
        $pdArdapus = PerangkatDaerah::where('slug', 'ardapus')->first();

        Berita::create([
            'kategori_berita_id' => $kategoriPemerintahan->id,
            'kecamatan_id' => null,
            'perangkat_daerah_id' => null,
            'judul' => 'Pemkab Subang Raih Penghargaan Kabupaten Inovatif 2025',
            'slug' => Str::slug('Pemkab Subang Raih Penghargaan Kabupaten Inovatif 2025'),
            'excerpt' => 'Pemerintah Kabupaten Subang berhasil meraih penghargaan sebagai salah satu kabupaten paling inovatif dalam pelayanan publik tingkat nasional.',
            'isi' => '<p>Pemerintah Kabupaten Subang berhasil meraih penghargaan sebagai salah satu kabupaten paling inovatif dalam pelayanan publik tingkat nasional. Penghargaan ini diberikan atas berbagai terobosan digital yang memudahkan masyarakat.</p>',
            'published_at' => now()->subDays(1),
        ]);

        if ($kecamatanBinong) {
            Berita::create([
                'kategori_berita_id' => $kategoriPemerintahan->id,
                'kecamatan_id' => $kecamatanBinong->id,
                'perangkat_daerah_id' => null,
                'judul' => 'Kecamatan Binong Gelar Musrenbang untuk Pembangunan 2026',
                'slug' => Str::slug('Kecamatan Binong Gelar Musrenbang untuk Pembangunan 2026'),
                'excerpt' => 'Musyawarah Perencanaan Pembangunan (Musrenbang) Kecamatan Binong dihadiri oleh seluruh elemen masyarakat untuk menyusun prioritas pembangunan.',
                'isi' => '<p>Musyawarah Perencanaan Pembangunan (Musrenbang) Kecamatan Binong dihadiri oleh seluruh elemen masyarakat untuk menyusun prioritas pembangunan. Fokus utama adalah perbaikan infrastruktur pertanian dan jalan desa.</p>',
                'published_at' => now()->subDays(2),
            ]);
        }

        if ($pdArdapus) {
            Berita::create([
                'kategori_berita_id' => $kategoriPendidikan->id,
                'kecamatan_id' => null,
                'perangkat_daerah_id' => $pdArdapus->id,
                'judul' => 'Ardapus Luncurkan Program Digitalisasi Arsip Desa',
                'slug' => Str::slug('Ardapus Luncurkan Program Digitalisasi Arsip Desa'),
                'excerpt' => 'Dinas Kearsipan dan Perpustakaan (Ardapus) Subang memulai program digitalisasi arsip penting di seluruh desa sebagai upaya pelestarian dokumen.',
                'isi' => '<p>Dinas Kearsipan dan Perpustakaan (Ardapus) Subang memulai program digitalisasi arsip penting di seluruh desa sebagai upaya pelestarian dokumen. Program ini akan berjalan selama satu tahun ke depan.</p>',
                'published_at' => now()->subDays(3),
            ]);
        }
    }
}