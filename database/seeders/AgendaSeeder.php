<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // Tambahkan model PerangkatDaerah
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum mengisi data baru
        DB::table('agendas')->delete();

        // === Seeding untuk Kecamatan ===
        $binong = Kecamatan::where('name', 'Binong')->first();
        $blanakan = Kecamatan::where('name', 'Blanakan')->first();

        if ($binong) {
            Agenda::create([
                'kecamatan_id' => $binong->id,
                'perangkat_daerah_id' => null, // Pastikan kolom lain diisi null
                'judul' => 'Rapat Koordinasi Persiapan Lomba Desa Tingkat Kabupaten',
                'deskripsi' => 'Rapat bersama para kepala desa di Kecamatan Binong untuk membahas persiapan lomba desa.',
                'tanggal_mulai' => Carbon::parse('2025-07-15'),
                'tanggal_selesai' => Carbon::parse('2025-07-15'),
            ]);
            Agenda::create([
                'kecamatan_id' => $binong->id,
                'perangkat_daerah_id' => null,
                'judul' => 'Penyuluhan Pertanian Modern untuk Petani Lokal',
                'deskripsi' => 'Pelatihan penggunaan teknologi drone untuk pemupukan sawah di wilayah Binong.',
                'tanggal_mulai' => Carbon::parse('2025-08-05'),
                'tanggal_selesai' => Carbon::parse('2025-08-07'),
            ]);
            // [BARU] Menambahkan agenda di masa depan untuk demonstrasi
            Agenda::create([
                'kecamatan_id' => $binong->id,
                'perangkat_daerah_id' => null,
                'judul' => 'Festival Budaya dan Kesenian Rakyat Binong',
                'deskripsi' => 'Perayaan tahunan yang menampilkan berbagai kesenian dan budaya lokal Kecamatan Binong.',
                'tanggal_mulai' => Carbon::parse('2025-08-17'),
                'tanggal_selesai' => Carbon::parse('2025-08-18'),
            ]);
        }

        if ($blanakan) {
            Agenda::create([
                'kecamatan_id' => $blanakan->id,
                'perangkat_daerah_id' => null,
                'judul' => 'Sosialisasi Program Konservasi Hutan Mangrove',
                'deskripsi' => 'Mengajak masyarakat Blanakan untuk ikut serta dalam pelestarian ekosistem pesisir.',
                'tanggal_mulai' => Carbon::parse('2025-07-20'),
                'tanggal_selesai' => Carbon::parse('2025-07-20'),
            ]);
        }

        // === [PERBAIKAN] Seeding untuk Perangkat Daerah ===
        $ardapus = PerangkatDaerah::where('name', 'Ardapus')->first();
        $disdik = PerangkatDaerah::where('name', 'Dinas Pendidikan dan Kebudayaan')->first();

        if ($ardapus) {
            Agenda::create([
                'perangkat_daerah_id' => $ardapus->id,
                'kecamatan_id' => null, // Pastikan kolom lain diisi null
                'judul' => 'Workshop Literasi Digital untuk Pustakawan Sekolah',
                'deskripsi' => 'Meningkatkan kemampuan pustakawan dalam mengelola sumber daya digital di perpustakaan.',
                'tanggal_mulai' => Carbon::parse('2025-08-12'),
                'tanggal_selesai' => Carbon::parse('2025-08-13'),
            ]);
            Agenda::create([
                'perangkat_daerah_id' => $ardapus->id,
                'kecamatan_id' => null,
                'judul' => 'Pameran Arsip Sejarah Kabupaten Subang',
                'deskripsi' => 'Menampilkan dokumen dan foto bersejarah perjalanan Kabupaten Subang.',
                'tanggal_mulai' => Carbon::parse('2025-09-01'),
                'tanggal_selesai' => Carbon::parse('2025-09-10'),
            ]);
        }

        if ($disdik) {
            Agenda::create([
                'perangkat_daerah_id' => $disdik->id,
                'kecamatan_id' => null,
                'judul' => 'Olimpiade Sains Nasional (OSN) Tingkat Kabupaten',
                'deskripsi' => 'Seleksi siswa-siswi terbaik untuk mewakili Kabupaten Subang di tingkat provinsi.',
                'tanggal_mulai' => Carbon::parse('2025-08-20'),
                'tanggal_selesai' => Carbon::parse('2025-08-22'),
            ]);
        }
    }
}
