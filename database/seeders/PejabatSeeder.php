<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PejabatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi
        DB::table('pejabats')->delete();

        // Data Pejabat untuk Kabupaten Subang (tenant_id = null)
        $pejabat_kabupaten = [
            [
                'tenant_id' => null,
                'nama' => 'Dr. Drs. H. Imran, M.Si., MA.Cd',
                'jabatan' => 'Pj. Bupati Subang',
                'foto_url' => 'https://placehold.co/400x400/0ea5e9/ffffff?text=Foto',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'H. Asep Nuroni, S.Sos., M.Si.',
                'jabatan' => 'Sekretaris Daerah',
                'foto_url' => 'https://placehold.co/400x400/0ea5e9/ffffff?text=Foto',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Drs. H. Rahmat Fatharrahman, M.Si.',
                'jabatan' => 'Asisten Pemerintahan dan Kesejahteraan Rakyat',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Dr. H. Hidayat, S.Ag., M.Ag.',
                'jabatan' => 'Asisten Perekonomian dan Pembangunan',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Drs. H. Dadang Kurnianudin, M.Si.',
                'jabatan' => 'Asisten Administrasi Umum',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Hari Rubiyanto, S.STP, M.Si',
                'jabatan' => 'Kepala BAPPEDA',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Ahmad Sobari, S.Sos., M.AP',
                'jabatan' => 'Kepala BPKAD',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Drs. H. Ugit, M.Si',
                'jabatan' => 'Inspektur Daerah',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Tatang Komara, S.Pd., M.Si.',
                'jabatan' => 'Kepala Dinas Pendidikan dan Kebudayaan',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => null,
                'nama' => 'Drs. Asep Setia Permana, M.Si.',
                'jabatan' => 'Kepala Satuan Polisi Pamong Praja',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Data Pejabat untuk Kecamatan Binong (asumsi tenant_id = 1)
        $pejabat_kecamatan = [
            [
                'tenant_id' => 1,
                'nama' => 'Nama Camat Binong',
                'jabatan' => 'Camat',
                'foto_url' => 'https://placehold.co/400x400/0ea5e9/ffffff?text=Foto',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Sekretaris Camat',
                'jabatan' => 'Sekretaris Camat',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasi Pemerintahan',
                'jabatan' => 'Kasi Pemerintahan',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasi Trantibum',
                'jabatan' => 'Kasi Ketentraman dan Ketertiban Umum',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasi PMD',
                'jabatan' => 'Kasi Pemberdayaan Masyarakat dan Desa',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasi Kesos',
                'jabatan' => 'Kasi Kesejahteraan Sosial',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasi Pelayanan',
                'jabatan' => 'Kasi Pelayanan Umum',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasubbag Perencanaan',
                'jabatan' => 'Kasubbag Perencanaan dan Keuangan',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => 1,
                'nama' => 'Nama Kasubbag Kepegawaian',
                'jabatan' => 'Kasubbag Umum dan Kepegawaian',
                'foto_url' => 'https://placehold.co/400x400/e2e8f0/64748b?text=Foto',
                'urutan' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Gabungkan kedua array dan masukkan ke database
        DB::table('pejabats')->insert(array_merge($pejabat_kabupaten, $pejabat_kecamatan));
    }
}
