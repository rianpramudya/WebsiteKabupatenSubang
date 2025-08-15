<?php

namespace App\Observers;

use App\Models\WilayahAdministrasi;
use Illuminate\Support\Facades\Cache;

class WilayahAdministrasiObserver
{
    /**
     * Membersihkan cache terkait setelah data diubah.
     */
    private function clearCache(WilayahAdministrasi $wilayahAdministrasi)
    {
        // Hapus cache untuk kecamatan terkait
        Cache::forget('wilayah_administrasi_' . $wilayahAdministrasi->kecamatan_id);

        // Hapus cache untuk data agregat tingkat kabupaten
        Cache::forget('wilayah_administrasi_kabupaten');
    }

    public function created(WilayahAdministrasi $wilayahAdministrasi): void
    {
        $this->clearCache($wilayahAdministrasi);
    }

    public function updated(WilayahAdministrasi $wilayahAdministrasi): void
    {
        $this->clearCache($wilayahAdministrasi);
    }

    public function deleted(WilayahAdministrasi $wilayahAdministrasi): void
    {
        $this->clearCache($wilayahAdministrasi);
    }
}