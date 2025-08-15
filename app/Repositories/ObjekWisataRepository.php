<?php

namespace App\Repositories;

use App\Models\ObjekWisata;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ObjekWisataRepository
{
    protected int $cacheDurationHours = 1;

    public function getKategoriList(): Collection
    {
        return Cache::remember('objek_wisata.kategori_list', now()->addHours($this->cacheDurationHours), function () {
            return ObjekWisata::select('kategori')->distinct()->pluck('kategori');
        });
    }

    public function getWisataUnggulanForKecamatan(Kecamatan $kecamatan, int $count = 4): Collection
    {
        $cacheKey = "objek_wisata.kecamatan.{$kecamatan->id}.unggulan.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $count) {
            return $kecamatan->objekWisatas()
                ->where('is_unggulan', true)
                ->latest()
                ->take($count)
                ->get();
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil objek wisata unggulan untuk halaman utama perangkat daerah (dengan cache).
     */
    public function getWisataUnggulanForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, int $count = 4): Collection
    {
        $cacheKey = "objek_wisata.perangkat_daerah.{$perangkatDaerah->id}.unggulan.{$count}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $count) {
            return $perangkatDaerah->objekWisatas()
                ->where('is_unggulan', true)
                ->latest()
                ->take($count)
                ->get();
        });
    }

    public function getPaginatedForKecamatan(Kecamatan $kecamatan, Request $request, int $perPage = 9): LengthAwarePaginator
    {
        // ... (method yang sudah ada tidak berubah)
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $kategori = $request->get('kategori', '');
        $cacheKey = "objek_wisata.kecamatan.{$kecamatan->id}.paginated.page-{$page}.search-{$search}.kategori-{$kategori}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $request, $perPage) {
            $query = ObjekWisata::where('kecamatan_id', $kecamatan->id)
                ->orderBy('is_unggulan', 'desc')
                ->orderBy('nama', 'asc');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil data objek wisata dengan paginasi untuk perangkat daerah tertentu (dengan cache).
     */
    public function getPaginatedForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, Request $request, int $perPage = 9): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $kategori = $request->get('kategori', '');
        $cacheKey = "objek_wisata.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}.search-{$search}.kategori-{$kategori}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $request, $perPage) {
            $query = ObjekWisata::where('perangkat_daerah_id', $perangkatDaerah->id) // <-- Filter by perangkat_daerah_id
                ->orderBy('is_unggulan', 'desc')
                ->orderBy('nama', 'asc');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    public function getPaginatedForKabupaten(Request $request, int $perPage = 9): LengthAwarePaginator
    {
        // ... (method yang sudah ada dimodifikasi sedikit)
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $kategori = $request->get('kategori', '');
        $cacheKey = "objek_wisata.kabupaten.paginated.page-{$page}.search-{$search}.kategori-{$kategori}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($request, $perPage) {
            $query = ObjekWisata::whereNull('kecamatan_id')->whereNull('perangkat_daerah_id') // <-- Ditambahkan
                ->orderBy('is_unggulan', 'desc')
                ->orderBy('nama', 'asc');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
