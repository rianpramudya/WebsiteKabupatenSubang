<?php

namespace App\Repositories;

use App\Models\Budaya;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BudayaRepository
{
    /**
     * Durasi cache default dalam jam.
     */
    protected int $cacheDurationHours = 1;

    /**
     * Mengambil data budaya terbaru untuk halaman utama kecamatan (dengan cache).
     */
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

    /**
     * [METHOD BARU]
     * Mengambil data budaya terbaru untuk halaman utama Perangkat Daerah (dengan cache).
     */
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

    /**
     * Mengambil data budaya dengan paginasi untuk halaman daftar budaya kecamatan (dengan cache).
     */
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

    /**
     * [METHOD BARU]
     * Mengambil data budaya dengan paginasi untuk halaman daftar budaya Perangkat Daerah (dengan cache).
     */
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

    /**
     * Mengambil data budaya dengan paginasi untuk tingkat kabupaten (dengan cache).
     */
    public function getPaginatedForKabupaten(int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "budaya.kabupaten.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perPage) {
            return Budaya::whereNull('kecamatan_id')->whereNull('perangkat_daerah_id') // <-- Ditambahkan
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    /**
     * Membersihkan semua cache.
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
