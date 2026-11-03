<?php

namespace App\Repositories;

use App\Models\Berita;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Tags\Tag;

class BeritaRepository
{
    protected int $cacheDurationHours = 1;

    public function getBeritaTerkiniForKecamatan(Kecamatan $kecamatan, int $count = 5): Collection
    {
        $cacheKey = "berita.kecamatan.{$kecamatan->id}.terkini.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->beritas()->whereNotNull('published_at')->latest('published_at')->take($count)->get();
        });
    }

    public function getBeritaPopulerForKecamatan(Kecamatan $kecamatan, int $count = 5): Collection
    {
        $cacheKey = "berita.kecamatan.{$kecamatan->id}.populer.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->beritas()->whereNotNull('published_at')->orderByDesc('views')->take($count)->get();
        });
    }

    public function getBeritaTerkiniForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $count = 5): Collection
    {
        $cacheKey = "berita.perangkatdaerah.{$perangkatDaerah->id}.terkini.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $count) {
            return $perangkatDaerah->beritas()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take($count)
                ->get();
        });
    }

    public function getBeritaPopulerForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $count = 5): Collection
    {
        $cacheKey = "berita.perangkatdaerah.{$perangkatDaerah->id}.populer.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $count) {
            return $perangkatDaerah->beritas()
                ->whereNotNull('published_at')
                ->orderByDesc('views')
                ->take($count)
                ->get();
        });
    }

    public function getPaginatedForTag(Tag $tag, int $perPage = 9): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "berita.tag.{$tag->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($tag, $perPage) {
            return Berita::withAllTags([$tag])->with(['kecamatan', 'kategori'])->latest('published_at')->paginate($perPage);
        });
    }

    public function getPaginatedForAll(int $perPage = 9): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "berita.semua.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perPage) {
            return Berita::with('kategori')->latest('published_at')->paginate($perPage);
        });
    }

    public function getPaginatedForKecamatan(Kecamatan $kecamatan, int $perPage = 10): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "berita.kecamatan.{$kecamatan->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return Berita::where('kecamatan_id', $kecamatan->id)->latest('published_at')->paginate($perPage);
        });
    }

    public function findBySlug(string $slug): ?Berita
    {
        $cacheKey = "berita.slug.{$slug}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($slug) {
            return Berita::with(['tags', 'kategori', 'kecamatan', 'perangkatDaerah'])->where('slug', $slug)->firstOrFail();
        });
    }

    public function getRelatedBerita(Berita $berita, int $count = 3): Collection
    {
        $cacheKey = "berita.{$berita->id}.terkait.{$count}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($berita, $count) {
            return Berita::where('kategori_berita_id', $berita->kategori_berita_id)
                ->where('id', '!=', $berita->id)
                ->latest('published_at')
                ->take($count)
                ->get();
        });
    }

    public function getPaginatedBeritaForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $perPage)
    {
        $page = request('page', 1);
        $cacheKey = "berita.perangkatdaerah.{$perangkatDaerah->id}.paginated.page-{$page}";
        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $perPage) {
            return Berita::query()
                ->with('kategori')
                ->where('perangkat_daerah_id', $perangkatDaerah->id)
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    public function clearCacheForKecamatan(Kecamatan $kecamatan): void
    {
        Cache::forget("berita.kecamatan.{$kecamatan->id}.terkini.5");
        Cache::forget("berita.kecamatan.{$kecamatan->id}.populer.5");
    }

    public function clearCacheForPerangkatDaerah(PerangkatDaerah $perangkatDaerah): void
    {

        Cache::forget("berita.perangkatdaerah.{$perangkatDaerah->id}.terkini.5");
        Cache::forget("berita.perangkatdaerah.{$perangkatDaerah->id}.populer.5");
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("berita.perangkatdaerah.{$perangkatDaerah->id}.paginated.page-{$i}");
        }
    }

    public function clearCacheForAll(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("berita.semua.paginated.page-{$i}");
        }
    }

    public function getPaginatedForTagAndKecamatan(Tag $tag, Kecamatan $kecamatan, int $perPage): LengthAwarePaginator
    {
        return Berita::withAllTags([$tag])
            ->where('kecamatan_id', $kecamatan->id)
            ->with(['kecamatan', 'kategori'])
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function getPaginatedForTagAndPerangkatDaerah(Tag $tag, PerangkatDaerah $perangkatDaerah, int $perPage): LengthAwarePaginator
    {
        return Berita::withAllTags([$tag])
            ->where('perangkat_daerah_id', $perangkatDaerah->id)
            ->with(['perangkatDaerah', 'kategori'])
            ->latest('published_at')
            ->paginate($perPage);
    }

}
