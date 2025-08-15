<?php

namespace App\Repositories;

use App\Models\RumahMakan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RumahMakanRepository
{
    /**
     * Durasi cache default dalam jam.
     */
    protected int $cacheDurationHours = 1;

    /**
     * Mengambil data rumah makan dengan paginasi untuk kecamatan tertentu (dengan cache).
     */
    public function getPaginatedForKecamatan(Kecamatan $kecamatan, Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $cacheKey = "rumah_makan.kecamatan.{$kecamatan->id}.paginated.page-{$page}.search-{$search}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $request, $perPage) {
            $query = RumahMakan::where('kecamatan_id', $kecamatan->id)
                ->whereNotNull('published_at')
                ->latest('published_at');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil data rumah makan dengan paginasi untuk perangkat daerah tertentu (dengan cache).
     */
    public function getPaginatedForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $cacheKey = "rumah_makan.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}.search-{$search}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $request, $perPage) {
            $query = RumahMakan::where('perangkat_daerah_id', $perangkatDaerah->id) // <-- Filter by perangkat_daerah_id
                ->whereNotNull('published_at')
                ->latest('published_at');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    /**
     * Mengambil data rumah makan dengan paginasi untuk tingkat kabupaten (dengan cache).
     */
    public function getPaginatedForKabupaten(Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $cacheKey = "rumah_makan.kabupaten.paginated.page-{$page}.search-{$search}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($request, $perPage) {
            $query = RumahMakan::whereNull('kecamatan_id')->whereNull('perangkat_daerah_id') // <-- Ditambahkan
                ->whereNotNull('published_at')
                ->latest('published_at');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }

            return $query->paginate($perPage)->withQueryString();
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
