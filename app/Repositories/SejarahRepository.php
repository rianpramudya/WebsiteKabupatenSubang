<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Sejarah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class SejarahRepository
{
    protected int $cacheDurationHours = 24;

    public function getProfilData(Kecamatan|PerangkatDaerah|null $context): Kecamatan|PerangkatDaerah
    {
        if ($context) {
            return $context;
        }

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
        } else {
            $cacheKey .= "perangkat_daerah.{$profilData->id}";
        }

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($profilData) {
            if ($profilData instanceof Kecamatan && $profilData->slug === 'kabupaten-subang') {

                return Sejarah::whereNull('kecamatan_id')
                    ->whereNull('perangkat_daerah_id')
                    ->orderBy('urutan')
                    ->get();
            }

            return $profilData->sejarahs()->orderBy('urutan')->get();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
