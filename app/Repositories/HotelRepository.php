<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HotelRepository
{
    protected int $cacheDurationHours = 1;

    public function getPaginatedForKecamatan(Kecamatan $kecamatan, Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $cacheKey = "hotel.kecamatan.{$kecamatan->id}.paginated.page-{$page}.search-{$search}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $request, $perPage) {
            $query = Hotel::where('kecamatan_id', $kecamatan->id)
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
     * Mengambil data hotel dengan paginasi untuk Perangkat Daerah tertentu (dengan cache).
     */
    public function getPaginatedForPerangkatDaerah(PerangkatDaerah $perangkatDaerah, Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $cacheKey = "hotel.perangkat_daerah.{$perangkatDaerah->id}.paginated.page-{$page}.search-{$search}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah, $request, $perPage) {
            $query = Hotel::where('perangkat_daerah_id', $perangkatDaerah->id) // <-- Filter by perangkat_daerah_id
                ->whereNotNull('published_at')
                ->latest('published_at');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    public function getPaginatedForKabupaten(Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $cacheKey = "hotel.kabupaten.paginated.page-{$page}.search-{$search}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($request, $perPage) {
            $query = Hotel::whereNull('kecamatan_id')->whereNull('perangkat_daerah_id') // <-- Ditambahkan
                ->whereNotNull('published_at')
                ->latest('published_at');

            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }

            return $query->paginate($perPage)->withQueryString();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
