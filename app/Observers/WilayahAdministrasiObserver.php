<?php

namespace App\Observers;

use App\Models\WilayahAdministrasi;
use Illuminate\Support\Facades\Cache;

class WilayahAdministrasiObserver
{

    private function clearCache(WilayahAdministrasi $wilayahAdministrasi)
    {

        Cache::forget('wilayah_administrasi_' . $wilayahAdministrasi->kecamatan_id);

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