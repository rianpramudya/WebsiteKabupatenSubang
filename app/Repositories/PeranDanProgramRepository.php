<?php

namespace App\Repositories;

use App\Models\PeranDanProgram;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class PeranDanProgramRepository
{
    /**
     * Durasi cache default dalam jam.
     */
    protected int $cacheDurationHours = 24; // Data ini jarang berubah

    /**
     * [MODIFIKASI]
     * Mengambil semua data Peran dan Program (dengan cache).
     *
     * @param Kecamatan|PerangkatDaerah|null $context
     * @return Collection
     */
    public function getAllPeranDanProgram(Kecamatan|PerangkatDaerah|null $context): Collection
    {
        $cacheKey = "peran_dan_program.";
        if ($context instanceof Kecamatan) {
            $cacheKey .= "kecamatan.{$context->id}";
        } elseif ($context instanceof PerangkatDaerah) {
            $cacheKey .= "perangkat_daerah.{$context->id}";
        } else {
            $cacheKey .= "kabupaten";
        }

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($context) {
            $query = PeranDanProgram::query()->orderBy('urutan');

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

    /**
     * Membersihkan semua cache.
     * Metode ini akan dipanggil oleh PeranDanProgramObserver.
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
