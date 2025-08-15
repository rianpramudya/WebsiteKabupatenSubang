<?php

namespace App\Repositories;

use App\Models\Penghargaan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class PenghargaanRepository
{
    /**
     * Durasi cache default dalam jam.
     */
    protected int $cacheDurationHours = 24; // Penghargaan jarang berubah

    /**
     * Mengambil data penghargaan yang dikelompokkan berdasarkan tahun.
     * Method ini sekarang bisa menerima Kecamatan, PerangkatDaerah, atau null (untuk Kabupaten).
     *
     * @param Kecamatan|PerangkatDaerah|null $context
     * @return Collection
     */
    public function getGroupedByYear(Kecamatan|PerangkatDaerah|null $context): Collection
    {
        $cacheKey = "penghargaan.";
        if ($context instanceof Kecamatan) {
            $cacheKey .= "kecamatan.{$context->id}";
        } elseif ($context instanceof PerangkatDaerah) {
            $cacheKey .= "perangkat_daerah.{$context->id}";
        } else {
            $cacheKey .= "kabupaten";
        }

        return Cache::remember($cacheKey, now()->addHours($this->cacheDurationHours), function () use ($context) {
            $query = Penghargaan::query()->orderBy('tahun', 'desc');

            if ($context instanceof Kecamatan) {
                // [PERBAIKAN] Menggunakan 'kecamatan_id' sesuai dengan skema database yang sebenarnya.
                $query->where('kecamatan_id', $context->id);
            } elseif ($context instanceof PerangkatDaerah) {
                // Ini sudah benar, dengan asumsi nama kolomnya 'perangkat_daerah_id'
                $query->where('perangkat_daerah_id', $context->id);
            } else {
                // [PERBAIKAN] Menggunakan 'kecamatan_id' untuk mencari penghargaan tingkat kabupaten (yang tidak memiliki relasi).
                $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
            }

            return $query->get()->groupBy('tahun');
        });
    }

    /**
     * Membersihkan semua cache.
     * Metode ini akan dipanggil oleh PenghargaanObserver.
     */
    public function clearCache(): void
    {
        // Catatan: flush() akan menghapus SEMUA cache aplikasi.
        // Pertimbangkan menggunakan Cache Tags jika aplikasi semakin kompleks.
        Cache::flush();
    }
}