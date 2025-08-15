<?php

namespace App\Repositories;

use App\Models\Galeri;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GaleriRepository
{
    protected int $cacheDurationHours = 1;

    public function getLatestPhotosForKecamatan(Kecamatan $kecamatan, int $count = 10): Collection
    {
        $cacheKey = "galeri.foto.kecamatan.{$kecamatan->id}.latest.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->galeris()->where('tipe', 'foto')->latest()->take($count)->get();
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil foto terbaru untuk halaman utama Perangkat Daerah (dengan cache).
     */
    public function getLatestPhotosForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $count = 10): Collection
    {
        $cacheKey = "galeri.foto.perangkat_daerah.{$perangkatDaerah->id}.latest.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $count) {
            return $perangkatDaerah->galeris()->where('tipe', 'foto')->latest()->take($count)->get();
        });
    }

    public function getLatestVideosForKecamatan(Kecamatan $kecamatan, int $count = 5): Collection
    {
        $cacheKey = "galeri.video.kecamatan.{$kecamatan->id}.latest.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->galeris()->whereIn('tipe', ['video_upload', 'video_yt'])->latest()->take($count)->get();
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil video terbaru untuk halaman utama Perangkat Daerah (dengan cache).
     */
    public function getLatestVideosForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $count = 5): Collection
    {
        $cacheKey = "galeri.video.perangkat_daerah.{$perangkatDaerah->id}.latest.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $count) {
            return $perangkatDaerah->galeris()->whereIn('tipe', ['video_upload', 'video_yt'])->latest()->take($count)->get();
        });
    }

    public function getPaginatedPhotosForKecamatan(Kecamatan $kecamatan, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "galeri.foto.kecamatan.{$kecamatan->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return $kecamatan->galeris()->where('tipe', 'foto')->latest()->paginate($perPage);
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil galeri foto dengan paginasi untuk Perangkat Daerah tertentu (dengan cache).
     */
    public function getPaginatedPhotosForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "galeri.foto.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $perPage) {
            return $perangkatDaerah->galeris()->where('tipe', 'foto')->latest()->paginate($perPage);
        });
    }

    public function getPaginatedVideosForKecamatan(Kecamatan $kecamatan, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "galeri.video.kecamatan.{$kecamatan->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return $kecamatan->galeris()->whereIn('tipe', ['video_upload', 'video_yt'])->latest()->paginate($perPage);
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil galeri video dengan paginasi untuk Perangkat Daerah tertentu (dengan cache).
     */
    public function getPaginatedVideosForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $perPage = 12): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "galeri.video.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $perPage) {
            return $perangkatDaerah->galeris()->whereIn('tipe', ['video_upload', 'video_yt'])->latest()->paginate($perPage);
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
