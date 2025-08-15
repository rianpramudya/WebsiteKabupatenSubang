<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use App\Models\Sejarah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class SejarahRepository
{
    protected int $cacheDurationHours = 24;

    /**
     * [MODIFIKASI]
     * Mengambil data profil umum (dari tabel kecamatans atau perangkat_daerahs).
     */
    public function getProfilData(Kecamatan|PerangkatDaerah|null $context): Kecamatan|PerangkatDaerah
    {
        if ($context) {
            return $context;
        }

        // Jika tidak ada konteks, ambil data Kabupaten
        $cacheKey = "sejarah.profil.kabupaten";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () {
            return Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        });
    }

    public function getSejarahItems(Kecamatan|PerangkatDaerah $profilData): Collection
    {
        $cacheKey = "sejarah.items.";
        if ($profilData instanceof Kecamatan) {
            $cacheKey .= "kecamatan.{$profilData->id}";
        } else { // PerangkatDaerah
            $cacheKey .= "perangkat_daerah.{$profilData->id}";
        }

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($profilData) {
            // [PERBAIKAN] Logika ini dikembalikan ke if/else yang benar
            if ($profilData instanceof Kecamatan && $profilData->slug === 'kabupaten-subang') {
                // Untuk Konteks Kabupaten, cari yang foreign key-nya NULL
                return Sejarah::whereNull('kecamatan_id')
                    ->whereNull('perangkat_daerah_id')
                    ->orderBy('urutan')
                    ->get();
            }

            // Untuk Kecamatan biasa atau Perangkat Daerah, gunakan relasi
            return $profilData->sejarahs()->orderBy('urutan')->get();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
