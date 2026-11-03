<?php

namespace App\Repositories;

use App\Models\Layanan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class LayananRepository
{

    protected int $cacheDurationHours = 24;

    public function getLayanansForKecamatan(Kecamatan $kecamatan): Collection
    {
        $cacheKey = "layanan.kecamatan.{$kecamatan->id}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan) {
            return $kecamatan->layanans()->orderBy('urutan', 'asc')->get();
        });
    }

    public function getLayanansForPerangkatDaerah(PerangkatDaerah $perangkatDaerah): Collection
    {
        $cacheKey = "layanan.perangkat_daerah.{$perangkatDaerah->id}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah) {
            return $perangkatDaerah->layanans()->orderBy('urutan', 'asc')->get();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
