<?php

namespace App\Repositories;

use App\Models\Pejabat;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class StrukturPemerintahanRepository
{
    protected int $cacheDurationHours = 24;

    public function getAllPejabat(Kecamatan|PerangkatDaerah|null $context): Collection
    {
        $cacheKey = "struktur_pemerintahan.";
        if ($context instanceof Kecamatan) {
            $cacheKey .= "kecamatan.{$context->id}";
        } elseif ($context instanceof PerangkatDaerah) {
            $cacheKey .= "perangkat_daerah.{$context->id}";
        } else {
            $cacheKey .= "kabupaten";
        }

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($context) {
            $query = Pejabat::query()->orderBy('urutan', 'asc');

            if ($context instanceof Kecamatan) {
                $query->where('kecamatan_id', $context->id);
            } elseif ($context instanceof PerangkatDaerah) {
                $query->where('perangkat_daerah_id', $context->id);
            } else {
                $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
            }

            return $query->get();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
