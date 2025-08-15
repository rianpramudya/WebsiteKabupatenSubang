<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use App\Models\WilayahAdministrasi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class WilayahAdministrasiRepository
{
    /**
     * [MODIFIKASI]
     * Mendapatkan semua data wilayah administrasi, dengan menggunakan cache.
     *
     * @param Kecamatan|PerangkatDaerah|null $context
     * @return Collection
     */
    public function getWilayahAdministrasiData(Kecamatan|PerangkatDaerah|null $context): Collection
    {
        $cacheKey = 'wilayah_administrasi_';
        if ($context instanceof Kecamatan) {
            $cacheKey .= "kecamatan.{$context->id}";
        } elseif ($context instanceof PerangkatDaerah) {
            $cacheKey .= "perangkat_daerah.{$context->id}";
        } else {
            $cacheKey .= "kabupaten";
        }

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($context) {
            if ($context instanceof Kecamatan || $context instanceof PerangkatDaerah) {
                // Method relasi 'wilayahAdministrasi' harus ada di kedua model
                return $context->wilayahAdministrasi()->orderBy('nama_desa')->get();
            } else {
                // Jika ini konteks kabupaten, kita ambil data agregat dari Kecamatan
                return Kecamatan::where('slug', '!=', 'kabupaten-subang')
                    ->withCount('wilayahAdministrasi')
                    ->withSum('wilayahAdministrasi as total_penduduk', 'jumlah_penduduk')
                    ->orderBy('name')
                    ->get();
            }
        });
    }
}
