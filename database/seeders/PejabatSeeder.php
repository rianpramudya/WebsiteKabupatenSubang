<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pejabat;
use App\Models\Kecamatan;

class PejabatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();

        if (!$kecamatanBinong) {
            $this->command->error('Data Kecamatan Binong tidak ditemukan. Jalankan KecamatanSeeder terlebih dahulu.');
            return;
        }

        // Data Pejabat untuk Kabupaten Subang
        $pejabat_kabupaten = [
            ['nama' => 'Dr. Drs. H. Imran, M.Si., MA.Cd', 'jabatan' => 'Pj. Bupati Subang', 'urutan' => 1, 'foto' => 'https://placehold.co/400x400/1E4E7C/ffffff?text=Foto'],
            ['nama' => 'H. Asep Nuroni, S.Sos., M.Si.', 'jabatan' => 'Sekretaris Daerah', 'urutan' => 2, 'foto' => 'https://placehold.co/400x400/1E4E7C/ffffff?text=Foto'],
            ['nama' => 'Drs. H. Rahmat Fatharrahman, M.Si.', 'jabatan' => 'Asisten Pemerintahan dan Kesejahteraan Rakyat', 'urutan' => 3],
            ['nama' => 'Dr. H. Hidayat, S.Ag., M.Ag.', 'jabatan' => 'Asisten Perekonomian dan Pembangunan', 'urutan' => 4],
            ['nama' => 'Drs. H. Dadang Kurnianudin, M.Si.', 'jabatan' => 'Asisten Administrasi Umum', 'urutan' => 5],
        ];

        // Data Pejabat untuk Kecamatan Binong
        $pejabat_kecamatan = [
            ['nama' => 'Nama Camat Binong', 'jabatan' => 'Camat', 'urutan' => 1, 'foto' => 'https://placehold.co/400x400/1E4E7C/ffffff?text=Foto'],
            ['nama' => 'Nama Sekretaris Camat', 'jabatan' => 'Sekretaris Camat', 'urutan' => 2],
        ];

        // Proses data Kabupaten menggunakan updateOrCreate
        foreach ($pejabat_kabupaten as $pejabat) {
            Pejabat::updateOrCreate(
                [
                    // --- PERBAIKAN KUNCI UNIK ---
                    'kecamatan_id' => null, // Kunci untuk data kabupaten
                    'nama' => $pejabat['nama'], 
                ],
                [
                    'jabatan' => $pejabat['jabatan'],
                    'urutan' => $pejabat['urutan'],
                    'foto' => $pejabat['foto'] ?? 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                ]
            );
        }

        // Proses data Kecamatan Binong menggunakan updateOrCreate
        foreach ($pejabat_kecamatan as $pejabat) {
            Pejabat::updateOrCreate(
                [
                    'kecamatan_id' => $kecamatanBinong->id,
                    'nama' => $pejabat['nama'],
                ],
                [
                    'jabatan' => $pejabat['jabatan'],
                    'urutan' => $pejabat['urutan'],
                    'foto' => $pejabat['foto'] ?? 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                ]
            );
        }
        
        $this->command->info('PejabatSeeder berhasil dijalankan.');
    }
}
