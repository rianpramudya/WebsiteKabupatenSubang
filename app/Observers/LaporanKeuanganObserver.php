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

    public function created(LaporanKeuangan $laporanKeuangan): void
    {
        $this->laporanKeuanganRepository->clearCache();
    }

    public function updated(LaporanKeuangan $laporanKeuangan): void
    {
        $this->laporanKeuanganRepository->clearCache();
    }

    public function deleted(LaporanKeuangan $laporanKeuangan): void
    {
        $this->laporanKeuanganRepository->clearCache();
    }
}
