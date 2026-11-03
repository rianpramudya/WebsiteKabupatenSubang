<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Models\LaporanKeuangan;
use App\Models\PerangkatDaerah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LaporanKeuanganRepository
{
    /**
     * Mengambil laporan keuangan yang dikelompokkan berdasarkan tahun.
     * Menggunakan cache untuk efisiensi.
     *
     * @param Model|null $context (Bisa berupa Kecamatan, PerangkatDaerah, atau null)
     * @return Collection
     */
    public function getGroupedByYear(Model $context = null): Collection
    {

        $cacheKey = 'laporan_keuangan.all';
        if ($context) {
            $contextType = $context instanceof Kecamatan ? 'kecamatan' : 'perangkat_daerah';
            $cacheKey = "laporan_keuangan.{$contextType}.{$context->id}";
        }

        return Cache::remember($cacheKey, now()->addHour(), function () use ($context) {

            $query = LaporanKeuangan::query()
                        ->withoutGlobalScopes()
                        ->orderBy('tahun', 'desc');

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
