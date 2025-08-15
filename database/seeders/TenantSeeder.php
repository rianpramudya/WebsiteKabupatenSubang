<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan; // <-- Gunakan model Kecamatan
use App\Models\Tenant;    // <-- Gunakan model Tenant
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    /**
     * Jalankan proses seeding database.
     */
    public function run(): void
    {
        // Kosongkan tabel untuk memastikan seeding berjalan bersih
        // Hapus tenants dulu karena memiliki foreign key ke kecamatans
        Tenant::query()->delete();
        Kecamatan::query()->delete();

        // Daftar nama kecamatan di Kabupaten Subang
        $kecamatanList = [
            'Binong', 'Blanakan', 'Ciasem', 'Ciater', 'Cibogo', 'Cijambe', 'Cikaum',
            'Cipeundeuy', 'Cipunagara', 'Cisalak', 'Compreng', 'Dawuan', 'Jalancagak',
            'Kalijati', 'Kasomalang', 'Legonkulon', 'Pagaden', 'Pagaden Barat', 'Pamanukan',
            'Patokbeusi', 'Pabuaran', 'Purwadadi', 'Pusakajaya', 'Pusakanagara',
            'Sagalaherang', 'Serangpanjang', 'Subang', 'Sukasari', 'Tambakdahan', 'Tanjungsiang'
        ];

        // Lakukan iterasi untuk setiap kecamatan
        foreach ($kecamatanList as $namaKecamatan) {
            $slug = Str::slug($namaKecamatan);

            // 1. Buat record di tabel 'kecamatans' terlebih dahulu
            $kecamatan = Kecamatan::create([
                'name' => $namaKecamatan,
                'slug' => $slug,
                // Anda bisa menambahkan data default lain di sini jika ada
                // 'logo' => 'logos/default.png',
            ]);

            // 2. Buat record di tabel 'tenants' dan hubungkan menggunakan ID dari kecamatan
            Tenant::create([
                'kecamatan_id' => $kecamatan->id, // <- Kunci utamanya ada di sini
                'name'         => $kecamatan->name,
                'slug'         => $kecamatan->slug,
                'subdomain'    => $slug, // subdomain biasanya tanpa .subang.go.id
                'status'       => 'active',
            ]);
        }
    }
}