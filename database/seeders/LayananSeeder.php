<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{

    public function run(): void
    {

        DB::table('layanans')->delete();

        $binong = Kecamatan::where('name', 'Binong')->first();
        $blanakan = Kecamatan::where('name', 'Blanakan')->first();

        if ($binong) {
            Layanan::create([
                'kecamatan_id' => $binong->id,
                'perangkat_daerah_id' => null,
                'nama' => 'Layanan KTP & KK',
                'deskripsi' => 'Pengurusan Kartu Tanda Penduduk (KTP) dan Kartu Keluarga (KK) untuk warga Kecamatan Binong.',
                'icon' => 'fas fa-id-card',
                'link_url' => null,
                'urutan' => 1
            ]);
            Layanan::create([
                'kecamatan_id' => $binong->id,
                'perangkat_daerah_id' => null,
                'nama' => 'Izin Mendirikan Bangunan (IMB)',
                'deskripsi' => 'Proses permohonan dan penerbitan IMB untuk bangunan baru atau renovasi di wilayah Binong.',
                'icon' => 'fas fa-building',
                'link_url' => null,
                'urutan' => 2
            ]);
        }

        if ($blanakan) {
            Layanan::create([
                'kecamatan_id' => $blanakan->id,
                'perangkat_daerah_id' => null,
                'nama' => 'Surat Keterangan Usaha (SKU)',
                'deskripsi' => 'Penerbitan surat keterangan untuk keperluan usaha mikro dan kecil bagi warga Blanakan.',
                'icon' => 'fas fa-store',
                'link_url' => null,
                'urutan' => 1
            ]);
        }

        $ardapus = PerangkatDaerah::where('name', 'Ardapus')->first();
        $disdukcapil = PerangkatDaerah::where('name', 'Disdukcapil')->first();

        if ($ardapus) {
            Layanan::create([
                'perangkat_daerah_id' => $ardapus->id,
                'kecamatan_id' => null,
                'nama' => 'Peminjaman Arsip',
                'deskripsi' => 'Layanan peminjaman arsip statis dan dinamis untuk keperluan penelitian dan pemerintahan.',
                'icon' => 'fas fa-archive',
                'link_url' => null,
                'urutan' => 1
            ]);
            Layanan::create([
                'perangkat_daerah_id' => $ardapus->id,
                'kecamatan_id' => null,
                'nama' => 'Pendaftaran Anggota Perpustakaan',
                'deskripsi' => 'Menjadi anggota perpustakaan daerah untuk mengakses ribuan koleksi buku dan digital.',
                'icon' => 'fas fa-book-reader',
                'link_url' => null,
                'urutan' => 2
            ]);
        }

        if ($disdukcapil) {
            Layanan::create([
                'perangkat_daerah_id' => $disdukcapil->id,
                'kecamatan_id' => null,
                'nama' => 'Aktivasi Identitas Kependudukan Digital',
                'deskripsi' => 'Layanan aktivasi IKD atau KTP Digital untuk kemudahan akses layanan publik.',
                'icon' => 'fas fa-mobile-alt',
                'link_url' => 'https://subang.go.id/layanan/ikd',
                'urutan' => 1
            ]);
        }
    }
}
