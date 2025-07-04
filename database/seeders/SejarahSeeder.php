<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sejarah;   // Model untuk timeline
use App\Models\Kecamatan; // Model untuk data utama wilayah

class SejarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === BAGIAN 1: MENGISI DATA UTAMA PADA TABEL KECAMATANS ===

        // 1. Data untuk Kabupaten Subang
        $kabupaten = Kecamatan::where('slug', 'kabupaten-subang')->first();
        if ($kabupaten) {
            $kabupaten->update([
                'sejarah' => '<h3>Prasejarah</h3><p>Bukti adanya kelompok masyarakat pada masa prasejarah di wilayah Kabupaten Subang adalah ditemukannya kapak batu di daerah Bojongkeding (Binong), Pagaden, Kalijati dan Dayeuhkolot (Sagalaherang). Temuan benda-benda prasejarah bercorak neolitikum ini menandakan bahwa saat itu di wilayah Kabupaten Subang sekarang sudah ada kelompok masyarakat yang hidup dari sektor pertanian dengan pola sangat sederhana.</p><p>Selain itu, dalam periode prasejarah juga berkembang pula pola kebudayaan perunggu yang ditandai dengan penemuan situs di Kampung Engkel, Sagalaherang.</p><h3>Hindu</h3><p>Pada saat berkembangnya corak kebudayaan Hindu, wilayah Kabupaten Subang menjadi bagian dari 3 kerajaan, yakni Tarumanagara, Galuh, dan Pajajaran...</p><h3>Islam</h3><p>Masa datangnya pengaruh kebudayaan Islam di wilayah Subang tidak terlepas dari peran seorang tokoh ulama, Wangsa Goparana yang berasal dari Talaga, Majalengka. Sekitar tahun 1530, Wangsa Goparana membuka permukiman baru di Sagalaherang dan menyebarkan agama Islam ke berbagai pelosok Subang.</p><h3>Kolonialisme</h3><p>Pasca runtuhnya kerajaan Pajajaran, wilayah Subang seperti halnya wilayah lain di P. Jawa, menjadi rebutan berbagai kekuatan. Tercatat kerajaan Banten, Mataram, Sumedanglarang, VOC, Inggris, dan Kerajaan Belanda berupaya menanamkan pengaruh di daerah yang cocok untuk dijadikan kawasan perkebunan serta strategis untuk menjangkau Batavia...</p><h3>Nasionalisme</h3><p>Tidak banyak catatan sejarah pergerakan pada awal abad ke-20 di Kabupaten Subang. Namun demikian, Setelah Kongres Sarekat Islam di bandung tahun 1916 di Subang berdiri cabang organisasi Sarekat Islam di Desa Pringkasap (Pabuaran) dan di Sukamandi (Ciasem)...</p><h3>Jepang</h3><p>Pendaratan tentara angkatan laut Jepang di pantai Eretan Timur tanggal 1 Maret 1942 berlanjut dengan direbutnya pangkalan udara Kalijati. Direbutnya pangkalan ini menjadi catatan tersendiri bagi sejarah pemerintahan Hindia Belanda, karena tak lama kemudian terjadi kapitulasi dari tentara Hindia Belanda kepada tentara Jepang...</p><h3>Merdeka</h3><p>Proklamasi Kemerdekaan RI di Jakarta berimbas pada didirikannya berbagai badan perjuangan di Subang... Penetapan nama Kabupaten Karawang Timur pada tanggal 5 April 1948 dijadikan momentum untuk kelahiran Kabupaten Subang yang kemudian ditetapkan melalui Keputusan DPRD No. : 01/SK/DPRD/1977.</p>',
                'arti_lambang' => '<ul><li><strong>Bintang:</strong> Melambangkan Ketuhanan Yang Maha Esa.</li><li><strong>Gunung dan Laut:</strong> Menggambarkan kekayaan alam Kabupaten Subang yang membentang dari pegunungan di selatan hingga pesisir di utara.</li><li><strong>Padi dan Kapas:</strong> Melambangkan cita-cita kemakmuran dan kesejahteraan bagi seluruh rakyat.</li></ul>',
                'logo' => 'logos/logo-subang.png', // Pastikan file ada di public/storage/logos/logo-subang.png
                'sejarah_img_1' => 'images/sejarah/subang-1.jpg', // Path gambar 1
                'sejarah_img_2' => 'images/sejarah/subang-2.jpg', // Path gambar 2
                'sejarah_img_3' => 'images/sejarah/subang-3.jpg', // Path gambar 3
                'visi' => 'Mewujudkan Subang sebagai kabupaten yang maju, sejahtera, dan berkarakter.',
                'misi' => '<ul><li>Meningkatkan kualitas sumber daya manusia.</li><li>Mengembangkan perekonomian daerah yang berdaya saing.</li><li>Meningkatkan kualitas infrastruktur dan lingkungan hidup.</li></ul>'
            ]);
        }

        // 2. Data untuk Kecamatan Binong
        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();
        if ($kecamatanBinong) {
            $kecamatanBinong->update([
                'sejarah' => '<p>Kecamatan Binong memiliki sejarah yang erat kaitannya dengan perkembangan pertanian di wilayah Subang. Sejak dulu, wilayah ini dikenal sebagai salah satu lumbung padi utama yang menyokong ketahanan pangan daerah. Perkembangan infrastruktur irigasi pada era modern semakin mengukuhkan posisinya sebagai pusat agraris yang vital.</p>',
                'arti_lambang' => '<p>Lambang Kecamatan Binong (jika ada) umumnya merefleksikan potensi utamanya, seperti hamparan padi yang menguning, yang melambangkan kemakmuran dan kesuburan tanahnya.</p>',
                'logo' => 'logos/logo-binong.png', // Ganti dengan path logo Kecamatan Binong jika ada
                'sejarah_img_1' => 'images/sejarah/binong-1.jpg', // Path gambar 1
                'sejarah_img_2' => 'images/sejarah/binong-2.jpg', // Path gambar 2
                'sejarah_img_3' => 'images/sejarah/binong-3.jpg', // Path gambar 3
                'visi' => 'Terwujudnya Kecamatan Binong yang agamis, maju, dan sejahtera.',
                'misi' => '<ul><li>Meningkatkan pelayanan publik yang prima.</li><li>Mengoptimalkan potensi pertanian dan ekonomi lokal.</li></ul>'
            ]);
        }


        // === BAGIAN 2: MENGISI DATA TIMELINE PADA TABEL SEJARAHS ===

        // Data Timeline untuk Kabupaten
        Sejarah::updateOrCreate(
            ['kecamatan_id' => null, 'tahun' => '1968'],
            [
                'judul' => 'Pembentukan Kabupaten',
                'deskripsi' => 'Kabupaten Subang secara resmi dibentuk sebagai daerah otonom terpisah dari Kabupaten Karawang berdasarkan Undang-Undang No. 4 Tahun 1968.',
                'urutan' => 1,
            ]
        );
        Sejarah::updateOrCreate(
            ['kecamatan_id' => null, 'tahun' => 'Era 1980-an'],
            [
                'judul' => 'Pembangunan Infrastruktur',
                'deskripsi' => 'Pembangunan infrastruktur besar-besaran dimulai, termasuk jalan utama dan fasilitas publik untuk mendukung pertumbuhan ekonomi daerah.',
                'urutan' => 2,
            ]
        );

        // Data Timeline untuk Kecamatan Binong
        if ($kecamatanBinong) {
            Sejarah::updateOrCreate(
                ['kecamatan_id' => $kecamatanBinong->id, 'tahun' => '1990-an'],
                [
                    'judul' => 'Pusat Pertanian Regional',
                    'deskripsi' => 'Kecamatan Binong berkembang menjadi salah satu lumbung padi utama di Kabupaten Subang, dengan modernisasi sistem irigasi yang meningkatkan hasil panen secara signifikan.',
                    'urutan' => 1,
                ]
            );
            Sejarah::updateOrCreate(
                ['kecamatan_id' => $kecamatanBinong->id, 'tahun' => '2010'],
                [
                    'judul' => 'Revitalisasi Pasar Tradisional',
                    'deskripsi' => 'Pasar Binong direvitalisasi menjadi pasar semi-modern untuk meningkatkan kenyamanan dan kebersihan, serta mendorong perekonomian lokal.',
                    'urutan' => 2,
                ]
            );
        }
    }
}
