<?php

namespace App\Repositories;

use App\Models\Infografis;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InfografisRepository
{
    protected int $cacheDurationHours = 1;

    public function getPaginatedForKecamatan(Kecamatan $kecamatan, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "infografis.kecamatan.{$kecamatan->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return Infografis::where('kecamatan_id', $kecamatan->id)
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil infografis dengan paginasi untuk Perangkat Daerah tertentu (dengan cache).
     */
    public function getPaginatedForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "infografis.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $perPage) {
            return Infografis::where('perangkat_daerah_id', $perangkatDaerah->id) // <-- Filter by perangkat_daerah_id
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    public function getPaginatedForKabupaten(int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "infografis.kabupaten.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perPage) {
            return Infografis::whereNull('kecamatan_id')->whereNull('perangkat_daerah_id') // <-- Ditambahkan
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
