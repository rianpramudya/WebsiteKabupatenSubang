<?php

namespace App\Repositories;

use App\Models\Penghargaan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class PenghargaanRepository
{

    protected int $cacheDurationHours = 24;

    /**
     * Mengambil data penghargaan yang dikelompokkan berdasarkan tahun.
     * Method ini sekarang bisa menerima Kecamatan, PerangkatDaerah, atau null (untuk Kabupaten).
     *
     * @param Kecamatan|PerangkatDaerah|null $context
     * @return Collection
     */
    public function getGroupedByYear(Kecamatan|PerangkatDaerah|null $context): Collection
    {
        $cacheKey = "penghargaan.";
        if ($context instanceof Kecamatan) {
            $cacheKey .= "kecamatan.{$context->id}";
        } elseif ($context instanceof PerangkatDaerah) {
            $cacheKey .= "perangkat_daerah.{$context->id}";
        } else {
            $cacheKey .= "kabupaten";
        }

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($context) {
            $query = Penghargaan::query()->orderBy('tahun', 'desc');

            if ($context instanceof Kecamatan) {
                $query->where('kecamatan_id', $context->id);
            } elseif ($context instanceof PerangkatDaerah) {

                $query->where('perangkat_daerah_id', $context->id);
            } else {
                $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
            }

            return $query->get()->groupBy('tahun');
        });
    }

    public function clearCache(): void
    {

        Cache::flush();
    }
}