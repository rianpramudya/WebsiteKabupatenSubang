<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{

    public function run(): void
    {

        Tenant::query()->delete();
        Kecamatan::query()->delete();

        $kecamatanList = [
            'Binong', 'Blanakan', 'Ciasem', 'Ciater', 'Cibogo', 'Cijambe', 'Cikaum',
            'Cipeundeuy', 'Cipunagara', 'Cisalak', 'Compreng', 'Dawuan', 'Jalancagak',
            'Kalijati', 'Kasomalang', 'Legonkulon', 'Pagaden', 'Pagaden Barat', 'Pamanukan',
            'Patokbeusi', 'Pabuaran', 'Purwadadi', 'Pusakajaya', 'Pusakanagara',
            'Sagalaherang', 'Serangpanjang', 'Subang', 'Sukasari', 'Tambakdahan', 'Tanjungsiang'
        ];

        foreach ($kecamatanList as $namaKecamatan) {
            $slug = Str::slug($namaKecamatan);

            $kecamatan = Kecamatan::create([
                'name' => $namaKecamatan,
                'slug' => $slug,

            ]);

            Tenant::create([
                'kecamatan_id' => $kecamatan->id,
                'name'         => $kecamatan->name,
                'slug'         => $kecamatan->slug,
                'subdomain'    => $slug,
                'status'       => 'active',
            ]);
        }
    }
}