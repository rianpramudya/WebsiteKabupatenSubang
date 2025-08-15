<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Str;

class PerangkatDaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel untuk awal yang bersih
        PerangkatDaerah::query()->delete();

        // Daftar lengkap Perangkat Daerah dari kode lama Anda
        $perangkatDaerahList = [
            ['name' => 'Sekretariat Daerah', 'singkatan' => 'setda', 'alamat' => 'Jl. Dewi Sartika No. 2, Subang'],
            ['name' => 'Sekretariat DPRD', 'singkatan' => 'setwan', 'alamat' => 'Jl. Panglejar No. 1, Subang'],
            ['name' => 'Inspektorat Daerah', 'singkatan' => 'irda', 'alamat' => 'Jl. S. Parman No. 101, Subang'],
            ['name' => 'Dinas Kearsipan dan Perpustakaan', 'singkatan' => 'ardapus', 'alamat' => 'Jl. Ade Irma Suryani Nasution No. 9, Subang'],
            ['name' => 'Dinas Kependudukan dan Pencatatan Sipil', 'singkatan' => 'disdukcapil', 'alamat' => 'Jl. K.S. Tubun No. 11, Subang'],
            ['name' => 'Dinas Kesehatan', 'singkatan' => 'dinkes', 'alamat' => 'Jl. Kapten Hanafiah No. 5, Subang'],
            ['name' => 'Dinas Ketahanan Pangan', 'singkatan' => 'disketpan', 'alamat' => 'Jl. Arief Rachman Hakim No. 1, Subang'],
            ['name' => 'Dinas Komunikasi dan Informatika', 'singkatan' => 'diskominfo', 'alamat' => 'Jl. Mayjen Sutoyo No.46, Subang'],
            ['name' => 'Dinas Koperasi, UKM, Perdagangan dan Perindustrian', 'singkatan' => 'dkupp', 'alamat' => 'Jl. K.S. Tubun No. 1, Subang'],
            ['name' => 'Dinas Lingkungan Hidup', 'singkatan' => 'dlh', 'alamat' => 'Jl. K.S. Tubun No. 13, Subang'],
            ['name' => 'Dinas Pariwisata, Kepemudaan dan Olahraga', 'singkatan' => 'disparpora', 'alamat' => 'Jl. Letjen S. Parman No. 103, Subang'],
            ['name' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'singkatan' => 'pupr', 'alamat' => 'Jl. K.S. Tubun No. 15, Subang'],
            ['name' => 'Dinas Pemberdayaan Masyarakat dan Desa', 'singkatan' => 'dispemberdes', 'alamat' => 'Jl. K.S. Tubun No. 17, Subang'],
            ['name' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'singkatan' => 'dpmptsp', 'alamat' => 'Jl. K.S. Tubun No. 19, Subang'],
            ['name' => 'Dinas Pendidikan dan Kebudayaan', 'singkatan' => 'disdikbud', 'alamat' => 'Jl. K.S. Tubun No. 4, Subang'],
            ['name' => 'Dinas Pengendalian Penduduk, KB, Pemberdayaan Perempuan dan Perlindungan Anak', 'singkatan' => 'dp2kbp3a', 'alamat' => 'Jl. K.S. Tubun No. 21, Subang'],
            ['name' => 'Dinas Perhubungan', 'singkatan' => 'dishub', 'alamat' => 'Jl. K.S. Tubun No. 23, Subang'],
            ['name' => 'Dinas Perikanan', 'singkatan' => 'diskan', 'alamat' => 'Jl. K.S. Tubun No. 25, Subang'],
            ['name' => 'Dinas Pertanian', 'singkatan' => 'pertanian', 'alamat' => 'Jl. K.S. Tubun No. 27, Subang'],
            ['name' => 'Dinas Perumahan, Kawasan Permukiman dan Pertanahan', 'singkatan' => 'diskimrum', 'alamat' => 'Jl. K.S. Tubun No. 29, Subang'],
            ['name' => 'Dinas Peternakan dan Kesehatan Hewan', 'singkatan' => 'disnakeswan', 'alamat' => 'Jl. K.S. Tubun No. 31, Subang'],
            ['name' => 'Dinas Sosial', 'singkatan' => 'dinsos', 'alamat' => 'Jl. K.S. Tubun No. 33, Subang'],
            ['name' => 'Dinas Tenaga Kerja dan Transmigrasi', 'singkatan' => 'disnakertrans', 'alamat' => 'Jl. K.S. Tubun No. 35, Subang'],
            ['name' => 'Satuan Polisi Pamong Praja dan Pemadam Kebakaran', 'singkatan' => 'satpolpp', 'alamat' => 'Jl. K.S. Tubun No. 37, Subang'],
            ['name' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia', 'singkatan' => 'bkpsdm', 'alamat' => 'Jl. K.S. Tubun No. 39, Subang'],
            ['name' => 'Badan Keuangan dan Aset Daerah', 'singkatan' => 'bkad', 'alamat' => 'Jl. S. Parman No. 101, Subang'],
            ['name' => 'Badan Perencanaan Pembangunan, Penelitian dan Pengembangan Daerah', 'singkatan' => 'bp4d', 'alamat' => 'Jl. S. Parman No. 101, Subang'],
            ['name' => 'Badan Pendapatan Daerah', 'singkatan' => 'bapenda', 'alamat' => 'Jl. S. Parman No. 101, Subang'],
            ['name' => 'Badan Penanggulangan Bencana Daerah', 'singkatan' => 'bpbd', 'alamat' => 'Jl. K.S. Tubun No. 41, Subang'],
            ['name' => 'Badan Kesatuan Bangsa dan Politik', 'singkatan' => 'bakesbangpol', 'alamat' => 'Jl. K.S. Tubun No. 43, Subang'],
        ];

        foreach ($perangkatDaerahList as $data) {
            $singkatan = $data['singkatan'];
            $namaLengkap = $data['name'];
            
            // Logika penamaan dari kode lama Anda
            $namaBaru = ucfirst($singkatan);
            $uppercaseAcronyms = ['pupr', 'dkupp', 'dpmptsp', 'dp2kbp3a', 'bkpsdm', 'bkad', 'bp4d', 'bapenda', 'bpbd'];
            if (in_array($singkatan, $uppercaseAcronyms)) {
                $namaBaru = strtoupper($singkatan);
            }
            if ($singkatan === 'satpolpp') {
                $namaBaru = 'Satpol PP';
            }
            $slugBaru = Str::slug($namaBaru);

            // Data dasar untuk semua Perangkat Daerah
            $pd_data = [
                'name' => $namaBaru,
                'slug' => $slugBaru,
                'logo' => 'logos/' . $singkatan . '.png',
                'alamat' => $data['alamat'] ?? 'Alamat belum tersedia',
                'telepon' => '(0260) 411000',
                'email' => $singkatan . '@subang.go.id',
                'visi' => 'Visi untuk ' . $namaLengkap . ' sedang dalam penyusunan.',
                'misi' => 'Misi untuk ' . $namaLengkap . ' sedang dalam penyusunan.',
            ];

            // Tambahkan data profil lengkap HANYA untuk Ardapus
            if ($singkatan === 'ardapus') {
                $pd_data = array_merge($pd_data, [
                    'name' => 'Dinas Kearsipan dan Perpustakaan', // Gunakan nama lengkap untuk Ardapus
                    'slug' => 'ardapus',
                    'sejarah_img_1' => 'sejarah_images/contoh-ardapus-1.jpg',
                    'sejarah_img_2' => 'sejarah_images/contoh-ardapus-2.jpg',
                    'sejarah_img_3' => 'sejarah_images/contoh-ardapus-3.jpg',
                    'visi' => 'Terwujudnya Pengelolaan Arsip dan Pengembangan Perpustakaan yang Profesional untuk Masyarakat Cerdas.',
                    'misi' => '<ul><li>Menyelamatkan dan melestarikan arsip sebagai memori kolektif bangsa.</li><li>Meningkatkan budaya baca dan literasi masyarakat.</li><li>Memberikan layanan kearsipan dan perpustakaan yang prima.</li></ul>',
                    'sejarah' => '<h3>Sejarah Ardapus Subang</h3><p>Dinas Kearsipan dan Perpustakaan (Ardapus) Kabupaten Subang dibentuk untuk mengemban amanat undang-undang dalam pengelolaan arsip daerah dan pengembangan minat baca masyarakat melalui perpustakaan.</p>',
                    'arti_lambang' => '<p>Logo Ardapus dengan ikon buku dan lembaran arsip melambangkan dua pilar utama dinas: pengetahuan dan memori.</p>',
                    'telepon' => '(0260) 411111',
                    'link_facebook' => 'https://facebook.com/ardapussubang',
                    'link_twitter' => 'https://twitter.com/ardapussubang',
                    'link_youtube' => 'https://youtube.com/ardapussubang',
                    'link_instagram' => 'https://instagram.com/ardapussubang',
                ]);
            }
            
            // Buat record di database
            PerangkatDaerah::create($pd_data);
        }
    }
}