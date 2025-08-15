<?php

namespace App\Observers;

use App\Models\LaporanKeuangan;
use App\Repositories\LaporanKeuanganRepository;

class LaporanKeuanganObserver
{
    protected LaporanKeuanganRepository $laporanKeuanganRepository;

    public function __construct()
    {
        $this->laporanKeuanganRepository = new LaporanKeuanganRepository();
    }

    /**
     * Handle the LaporanKeuangan "created" event.
     */
    public function created(LaporanKeuangan $laporanKeuangan): void
    {
        $this->laporanKeuanganRepository->clearCache();
    }

    /**
     * Handle the LaporanKeuangan "updated" event.
     */
    public function updated(LaporanKeuangan $laporanKeuangan): void
    {
        $this->laporanKeuanganRepository->clearCache();
    }

    /**
     * Handle the LaporanKeuangan "deleted" event.
     */
    public function deleted(LaporanKeuangan $laporanKeuangan): void
    {
        $this->laporanKeuanganRepository->clearCache();
    }
}
