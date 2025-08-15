<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sejarah;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // [1] Import model PerangkatDaerah

class SejarahSeeder extends Seeder
{
    public function run(): void
    {
        // === BAGIAN 1: MENGISI DATA UTAMA KECAMATAN (TERMASUK GAMBAR UTAMA) ===

        $kabupaten = Kecamatan::where('slug', 'kabupaten-subang')->first();
        if ($kabupaten) {
            $kabupaten->update([
                'sejarah' => '<h3>Prasejarah</h3><p>Wilayah Subang telah dihuni sejak zaman prasejarah, dibuktikan dengan penemuan kapak batu dan peninggalan lain di daerah Bojongkerta dan Kalijati.</p><h3>Masa Kerajaan</h3><p>Subang berada di bawah pengaruh kerajaan-kerajaan besar seperti Tarumanagara, Sunda, hingga Cirebon. Daerah ini menjadi jalur penting perdagangan dan penyebaran agama.</p>',
                'arti_lambang' => '<ul><li><strong>Bintang:</strong> Melambangkan Ketuhanan Yang Maha Esa.</li><li><strong>Gunung dan Laut:</strong> Menggambarkan kekayaan alam Subang dari pegunungan hingga pesisir.</li></ul>',
                'logo' => 'logos/logo-subang.png',
                'visi' => 'Mewujudkan Subang sebagai kabupaten yang maju, sejahtera, dan berkarakter.',
                'misi' => '<ul><li>Meningkatkan kualitas sumber daya manusia.</li><li>Mengembangkan potensi ekonomi daerah.</li><li>Mewujudkan tata kelola pemerintahan yang baik.</li></ul>',
                'sejarah_img_1' => 'sejarah_images/contoh-kabupaten-1.jpg',
                'sejarah_img_2' => 'sejarah_images/contoh-kabupaten-2.jpg',
                'sejarah_img_3' => 'sejarah_images/contoh-kabupaten-3.jpg',
            ]);
        }

        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();
        if ($kecamatanBinong) {
            $kecamatanBinong->update([
                'sejarah' => '<p>Kecamatan Binong memiliki sejarah yang erat dengan pengembangan pertanian di wilayah pantura Subang. Sejak zaman kolonial, daerah ini dikenal sebagai salah satu lumbung padi utama.</p>',
                'arti_lambang' => '<p>Lambang Kecamatan Binong dengan ikon padi melambangkan potensi utama wilayah sebagai pusat agraris yang subur dan makmur.</p>',
                'logo' => 'logos/logo-binong.png',
                'visi' => 'Terwujudnya Kecamatan Binong yang agamis, maju, dan sejahtera.',
                'misi' => '<ul><li>Meningkatkan pelayanan publik yang prima.</li><li>Mengoptimalkan potensi pertanian dan ekonomi lokal.</li></ul>',
                'sejarah_img_1' => 'sejarah_images/contoh-binong-1.jpg',
                'sejarah_img_2' => 'sejarah_images/contoh-binong-2.jpg',
                'sejarah_img_3' => 'sejarah_images/contoh-binong-3.jpg',
            ]);
        }

        // === BAGIAN 2: TIMELINE SEJARAH UNTUK KABUPATEN (kecamatan_id & perangkat_daerah_id = NULL) ===

        Sejarah::updateOrCreate(
            ['tahun' => '1968', 'kecamatan_id' => null, 'perangkat_daerah_id' => null],
            [
                'judul' => 'Pembentukan Kabupaten',
                'deskripsi' => 'Kabupaten Subang resmi terbentuk sebagai daerah otonom berdasarkan Undang-Undang No. 4 Tahun 1968.',
                'urutan' => 1,
            ]
        );

        Sejarah::updateOrCreate(
            ['tahun' => 'Era 1980-an', 'kecamatan_id' => null, 'perangkat_daerah_id' => null],
            [
                'judul' => 'Pembangunan Infrastruktur',
                'deskripsi' => 'Pembangunan besar-besaran termasuk jalan utama dan fasilitas publik mulai digalakkan untuk mendukung pertumbuhan ekonomi.',
                'urutan' => 2,
            ]
        );

        // === BAGIAN 3: TIMELINE UNTUK KECAMATAN BINONG ===

        if ($kecamatanBinong) {
            Sejarah::updateOrCreate(
                ['kecamatan_id' => $kecamatanBinong->id, 'tahun' => '1990-an'],
                [
                    'judul' => 'Pusat Pertanian Regional',
                    'deskripsi' => 'Binong berkembang menjadi lumbung padi utama di wilayah Pantura, menopang ketahanan pangan daerah.',
                    'urutan' => 1,
                ]
            );

            Sejarah::updateOrCreate(
                ['kecamatan_id' => $kecamatanBinong->id, 'tahun' => '2010'],
                [
                    'judul' => 'Revitalisasi Pasar Tradisional',
                    'deskripsi' => 'Pasar Binong direvitalisasi menjadi pasar semi-modern untuk meningkatkan perekonomian lokal.',
                    'urutan' => 2,
                ]
            );
        }

        // === [4] BAGIAN BARU: TIMELINE UNTUK PERANGKAT DAERAH (ARDAPUS) ===

        $ardapus = PerangkatDaerah::where('slug', 'ardapus')->first();
        if ($ardapus) {
            Sejarah::updateOrCreate(
                ['perangkat_daerah_id' => $ardapus->id, 'tahun' => '2007'],
                [
                    'judul' => 'Pembentukan Kantor Arsip',
                    'deskripsi' => 'Lembaga kearsipan daerah pertama kali dibentuk sebagai Kantor Arsip Daerah, fokus pada penyelamatan arsip statis.',
                    'urutan' => 1,
                ]
            );

            Sejarah::updateOrCreate(
                ['perangkat_daerah_id' => $ardapus->id, 'tahun' => '2016'],
                [
                    'judul' => 'Transformasi menjadi Dinas',
                    'deskripsi' => 'Berdasarkan Perda No. 7 Tahun 2016, lembaga ini berubah menjadi Dinas Kearsipan dan Perpustakaan (Ardapus) dengan fungsi yang lebih luas.',
                    'urutan' => 2,
                ]
            );
        }
    }
}
