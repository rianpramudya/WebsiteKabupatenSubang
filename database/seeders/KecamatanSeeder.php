<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        Kecamatan::query()->delete();

        // Data Profil Lengkap untuk Kabupaten Subang
        Kecamatan::create([
            'name' => 'Kabupaten Subang',
            'slug' => 'kabupaten-subang',
            'logo' => 'logos/logo-subang.png',
            
            // TAMBAHKAN BANNER - pilih salah satu contoh di bawah:
            'banner_url' => 'banners/kabupaten-subang-banner.jpg', // Untuk gambar
            // 'banner_url' => 'banners/kabupaten-subang-video.mp4', // Untuk video
            // 'banner_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Untuk YouTube
            
            'sejarah_img_1' => 'sejarah_images/contoh-kabupaten-1.jpg',
            'sejarah_img_2' => 'sejarah_images/contoh-kabupaten-2.jpg',
            'sejarah_img_3' => 'sejarah_images/contoh-kabupaten-3.jpg',
            'visi' => 'Mewujudkan Subang sebagai kabupaten yang maju, sejahtera, dan berkarakter.',
            'misi' => '<ul><li>Meningkatkan kualitas sumber daya manusia.</li><li>Mengembangkan perekonomian daerah yang berdaya saing.</li><li>Meningkatkan kualitas infrastruktur dan lingkungan hidup.</li></ul>',
            'sejarah' => '<h3>Sejarah Kabupaten Subang</h3><p>Bukti adanya kelompok masyarakat pada masa prasejarah di wilayah Kabupaten Subang adalah ditemukannya kapak batu di daerah Bojongkeding (Binong), Pagaden, Kalijati dan Dayeuhkolot (Sagalaherang). Temuan benda-benda prasejarah bercorak neolitikum ini menandakan bahwa saat itu di wilayah Kabupaten Subang sekarang sudah ada kelompok masyarakat yang hidup dari sektor pertanian dengan pola sangat sederhana.</p>',
            'arti_lambang' => '<ul><li><strong>Bintang:</strong> Melambangkan Ketuhanan Yang Maha Esa.</li><li><strong>Gunung dan Laut:</strong> Menggambarkan kekayaan alam Kabupaten Subang.</li><li><strong>Padi dan Kapas:</strong> Melambangkan cita-cita kemakmururan dan kesejahteraan.</li></ul>',
            'telepon' => '(0260) 411441',
            'email' => 'info@subang.go.id',
            'alamat' => 'Jl. Dewi Sartika No.2, Cigadung, Kec. Subang, Kabupaten Subang, Jawa Barat 41211',
            'link_facebook' => 'https://facebook.com/subangkab',
            'link_twitter' => 'https://twitter.com/subangkab',
            'link_youtube' => 'https://youtube.com/subangkab',
            'link_instagram' => 'https://instagram.com/subangkab',
            'peta_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253842.1969299443!2d107.57018364743436!3d-6.38662243425316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e692d4615a97579%3A0x301e8f1fc28b8e0!2sKabupaten%20Subang%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1662545089332!5m2!1sid!2sid',
        ]);

        $kecamatanList = [
            'Binong', 'Blanakan', 'Ciasem', 'Ciater', 'Cibogo', 'Cijambe', 'Cikaum', 'Cipeundeuy', 'Compreng', 'Dawuan', 'Jalancagak', 'Kalijati', 'Kasomalang', 'Legonkulon', 'Pagaden', 'Pagaden Barat', 'Pamanukan', 'Patokbeusi', 'Purwadadi', 'Pusakajaya', 'Pusakanagara', 'Sagalaherang', 'Serangpanjang', 'Subang', 'Sukasari', 'Tambakdahan', 'Tanjungsiang', 'Cipunagara', 'Cisalak', 'Pabuaran'
        ];

        foreach ($kecamatanList as $nama) {
            $slug = Str::slug($nama);
            $petaUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63426.43851996517!2d107.72895692695309!3d-6.495287699999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e693a968686739f%3A0x4424361ab6386821!2sKec.' . urlencode($nama) . '%2C%20Kabupaten%20Subang%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1662545169438!5m2!1sid!2sid';

            $data = [
                'name' => $nama,
                'slug' => $slug,
                'peta_url' => $petaUrl,
            ];

            if ($slug === 'binong') {
                $data = array_merge($data, [
                    'logo' => 'logos/logo-binong.png',
                    'banner_url' => 'banners/binong-banner.jpg', // TAMBAHKAN BANNER UNTUK BINONG JUGA
                    'sejarah_img_1' => 'sejarah_images/contoh-binong-1.jpg',
                    'sejarah_img_2' => 'sejarah_images/contoh-binong-2.jpg',
                    'sejarah_img_3' => 'sejarah_images/contoh-binong-3.jpg',
                    'visi' => 'Terwujudnya Kecamatan Binong yang Religius, Maju, dan Sejahtera.',
                    'misi' => '<ul><li>Meningkatkan kualitas pelayanan publik yang cepat, tepat, dan transparan.</li><li>Mendorong partisipasi masyarakat dalam setiap program pembangunan.</li><li>Mengoptimalkan potensi sumber daya alam dan manusia untuk kesejahteraan bersama.</li></ul>',
                    'sejarah' => '<h3>Sejarah Kecamatan Binong</h3><p>Kecamatan Binong memiliki sejarah yang erat kaitannya dengan perkembangan area pertanian di wilayah Pantura Subang. Sejak zaman kolonial, wilayah ini sudah dikenal sebagai lumbung padi yang subur dan strategis.</p>',
                    'arti_lambang' => '<p>Lambang Kecamatan Binong dengan ikon padi melambangkan kesuburan dan kemakmuran wilayahnya sebagai sentra agraris.</p>',
                    'telepon' => '(0260) 555123',
                    'email' => 'kec.binong@subang.go.id',
                    'alamat' => 'Jl. Raya Binong No. 1, Binong, Kabupaten Subang, Jawa Barat 41253',
                    'link_facebook' => 'https://facebook.com/kecbinong',
                    'link_twitter' => 'https://twitter.com/kecbinong',
                    'link_youtube' => 'https://youtube.com/kecbinong',
                    'link_instagram' => 'https://instagram.com/kecbinong',
                ]);
            }
            Kecamatan::create($data);
        }
    }
}