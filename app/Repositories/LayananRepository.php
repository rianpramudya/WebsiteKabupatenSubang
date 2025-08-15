<?php

namespace App\Repositories;

use App\Models\Layanan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class LayananRepository
{
    /**
     * Durasi cache default dalam jam.
     */
    protected int $cacheDurationHours = 24; // Data layanan jarang berubah

    /**
     * Mengambil semua data Layanan untuk sebuah kecamatan (dengan cache).
     */
    public function getLayanansForKecamatan(Kecamatan $kecamatan): Collection
    {
        $cacheKey = "layanan.kecamatan.{$kecamatan->id}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($kecamatan) {
            return $kecamatan->layanans()->orderBy('urutan', 'asc')->get();
        });
    }

    /**
     * [METHOD BARU]
     * Mengambil semua data Layanan untuk sebuah perangkat daerah (dengan cache).
     */
    public function getLayanansForPerangkatDaerah(PerangkatDaerah $perangkatDaerah): Collection
    {
        $cacheKey = "layanan.perangkat_daerah.{$perangkatDaerah->id}";

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($perangkatDaerah) {
            return $perangkatDaerah->layanans()->orderBy('urutan', 'asc')->get();
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
