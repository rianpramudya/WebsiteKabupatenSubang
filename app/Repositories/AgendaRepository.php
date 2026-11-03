<?php

namespace App\Repositories;

use App\Models\Agenda;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class AgendaRepository
{

    protected int $cacheDurationHours = 1;

    /**
     * Mengambil data agenda untuk halaman utama kecamatan (dengan cache).
     *
     * @param Kecamatan $kecamatan
     * @return Collection
     */
    public function getHomepageAgendasForKecamatan(Kecamatan $kecamatan): Collection
    {
        $cacheKey = "agenda.kecamatan.{$kecamatan->id}.homepage";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan) {
            return $kecamatan->agendas()
                ->whereBetween('tanggal_mulai', [
                    today()->subMonths(6),
                    today()->addMonths(12)
                ])
                ->orderBy('tanggal_mulai', 'asc')
                ->get();
        });
    }

    /**
     * Mengambil agenda dengan paginasi untuk halaman daftar agenda kecamatan (dengan cache).
     *
     * @param Kecamatan $kecamatan
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedAgendasForKecamatan(Kecamatan $kecamatan, int $perPage = 10): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "agenda.kecamatan.{$kecamatan->id}.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan, $perPage) {
            return $kecamatan->agendas()
                ->orderBy('tanggal_mulai', 'desc')
                ->paginate($perPage);
        });
    }

    /**
     * Mengambil agenda dengan paginasi untuk halaman daftar agenda kabupaten (dengan cache).
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedAgendasForKabupaten(int $perPage = 10): LengthAwarePaginator
    {
        $page = request('page', 1);
        $cacheKey = "agenda.kabupaten.paginated.page-{$page}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perPage) {
            return Agenda::whereNull('kecamatan_id')
                ->orderBy('tanggal_mulai', 'desc')
                ->paginate($perPage);
        });
    }

    public function getHomepageAgendasForPerangkatDaerah(PerangkatDaerah $perangkatDaerah): Collection
    {
        $cacheKey = "agenda.perangkat_daerah.{$perangkatDaerah->id}.homepage";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah) {
            return $perangkatDaerah->agendas()
                ->whereBetween('tanggal_mulai', [
                    today()->subMonths(6),
                    today()->addMonths(12)
                ])
                ->orderBy('tanggal_mulai', 'asc')
                ->get();
        });
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}
