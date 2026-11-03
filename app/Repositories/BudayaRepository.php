<?php

namespace App\Repositories;

use App\Models\Budaya;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BudayaRepository
{

    protected int $cacheDurationHours = 1;

    public function getLatestForKecamatan(Kecamatan $kecamatan, int $count = 3): Collection
    {
        $cacheKey = "budaya.kecamatan.{$kecamatan->id}.latest.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->budayas()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take($count)
                ->get();
        });
    }

    public function getLatestForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $count = 3): Collection
    {
        $cacheKey = "budaya.perangkat_daerah.{$perangkatDaerah->id}.latest.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $count) {
            return $perangkatDaerah->budayas()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take($count)
                ->get();
        });
    }

    public function getPaginatedForKecamatan(Kecamatan $kecamatan, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "budaya.kecamatan.{$kecamatan->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return $kecamatan->budayas()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    public function getPaginatedForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "budaya.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $perPage) {
            return $perangkatDaerah->budayas()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    public function getPaginatedForKabupaten(int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "budaya.kabupaten.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perPage) {
            return Budaya::whereNull('kecamatan_id')->whereNull('perangkat_daerah_id')
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
