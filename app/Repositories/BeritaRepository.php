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
    /**
     * Durasi cache default dalam jam.
     */
    protected int $cacheDurationHours = 1;

    // --- PENAMBAHAN: Metode untuk Berita Terkini ---
    /**
     * Mengambil berita terkini untuk halaman utama kecamatan (dengan cache).
     *
     * @param Kecamatan $kecamatan
     * @param int $count
     * @return Collection
     */
    public function getBeritaTerkiniForKecamatan(Kecamatan $kecamatan, int $count = 5): Collection
    {
        $cacheKey = "berita.kecamatan.{$kecamatan->id}.terkini.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->beritas()
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->take($count)
                ->get();
        });
    }

    public function getPaginatedForTag(Tag $tag, int $perPage = 9): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "berita.tag.{$tag->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($tag, $perPage) {
            return Berita::withAllTags([$tag])
                ->with(['kecamatan', 'kategori']) // eager load relations
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    // --- PENAMBAHAN: Metode untuk Berita Populer ---
    /**
     * Mengambil berita populer untuk halaman utama kecamatan (dengan cache).
     *
     * @param Kecamatan $kecamatan
     * @param int $count
     * @return Collection
     */
    public function getBeritaPopulerForKecamatan(Kecamatan $kecamatan, int $count = 5): Collection
    {
        $cacheKey = "berita.kecamatan.{$kecamatan->id}.populer.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->beritas()
                ->whereNotNull('published_at')
                ->orderByDesc('views')
                ->take($count)
                ->get();
        });
    }

    /**
     * Mengambil daftar semua berita dengan paginasi (dengan cache).
     */
    public function getPaginatedForAll(int $perPage = 9): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "berita.semua.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perPage) {
            return Berita::with('kategori')
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    /**
     * Mengambil daftar berita dengan paginasi untuk kecamatan tertentu (dengan cache).
     */
    public function getPaginatedForKecamatan(Kecamatan $kecamatan, int $perPage = 10): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "berita.kecamatan.{$kecamatan->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return Berita::where('kecamatan_id', $kecamatan->id)
                ->latest('published_at')
                ->paginate($perPage);
        });
    }

    /**
     * Mencari satu berita berdasarkan slug-nya (dengan cache).
     */
    public function findBySlug(string $slug): ?Berita
    {
        $cacheKey = "berita.slug.{$slug}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($slug) {
            return Berita::with(['tags', 'kategori', 'kecamatan'])->where('slug', $slug)->firstOrFail();
        });
    }

    /**
     * Mengambil berita terkait berdasarkan kategori yang sama (dengan cache).
     */
    public function getRelatedBerita(Berita $berita, int $count = 3): Collection
    {
        $cacheKey = "berita.{$berita->id}.terkait.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($berita, $count) {
            if ($berita->tags->isNotEmpty()) {
                return Berita::where('kategori_berita_id', $berita->kategori_berita_id)
                    ->where('id', '!=', $berita->id)
                    ->latest('published_at')
                    ->take($count)
                    ->get();
            }

            return Berita::where('kategori_berita_id', $berita->kategori_berita_id)
                ->where('id', '!=', $berita->id)
                ->latest('published_at')
                ->take($count)
                ->get();
        });
    }

    /**
     * Membersihkan semua cache.
     */
    public function clearCacheForKecamatan(Kecamatan $kecamatan): void
    {
        Cache::flush();
    }

    /**
 * [METHOD BARU]
 * Mengambil berita yang sudah dipaginasi untuk sebuah Perangkat Daerah.
 */
public function getPaginatedBeritaForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $perPage)
{
    return Berita::query()
        ->with('kategori')
        ->where('perangkat_daerah_id', $perangkatDaerah->id) // <-- Kunci pemfilteran
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->paginate($perPage);
}
}
