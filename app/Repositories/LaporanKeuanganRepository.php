<?php

namespace App\Repositories;

use App\Models\Kecamatan;
use App\Models\LaporanKeuangan;
use App\Models\PerangkatDaerah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LaporanKeuanganRepository
{
    /**
     * Mengambil laporan keuangan yang dikelompokkan berdasarkan tahun.
     * Menggunakan cache untuk efisiensi.
     *
     * @param Model|null $context (Bisa berupa Kecamatan, PerangkatDaerah, atau null)
     * @return Collection
     */
    public function getGroupedByYear(Model $context = null): Collection
    {
        // Tentukan kunci cache yang unik berdasarkan konteks
        $cacheKey = 'laporan_keuangan.all';
        if ($context) {
            $contextType = $context instanceof Kecamatan ? 'kecamatan' : 'perangkat_daerah';
            $cacheKey = "laporan_keuangan.{$contextType}.{$context->id}";
        }

        // Ambil dari cache jika ada, atau query ke database
        return Cache::remember($cacheKey, now()->addHour(), function () use ($context) {
            
            // PERBAIKAN UTAMA:
            // 1. Gunakan withoutGlobalScope untuk menghindari error 'tenant_id' not found dari scope lain.
            // 2. Gunakan kolom 'kecamatan_id' yang benar, bukan 'tenant_id'.
            $query = LaporanKeuangan::query()
                        ->withoutGlobalScopes() // Mengabaikan semua global scope untuk query ini
                        ->orderBy('tahun', 'desc');

            if ($context instanceof Kecamatan) {
                $query->where('kecamatan_id', $context->id);
            } elseif ($context instanceof PerangkatDaerah) {
                $query->where('perangkat_daerah_id', $context->id);
            } else {
                // Untuk halaman kabupaten, tampilkan yang tidak terikat ke kecamatan/PD
                $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
            }

            return $query->get()->groupBy('tahun');
        });
    }

    /**
     * Membersihkan semua cache yang terkait dengan laporan keuangan.
     * Metode ini bisa dipanggil oleh LaporanKeuanganObserver saat ada perubahan data.
     */
    public function clearCache(): void
    {
        // Cara yang lebih aman adalah membersihkan cache dengan tag,
        // tapi untuk sekarang flush sudah cukup.
        Cache::flush();
    }
}
