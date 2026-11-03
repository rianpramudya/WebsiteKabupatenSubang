<?php

namespace App\Observers;

use App\Models\Penghargaan;
use App\Repositories\PenghargaanRepository;

class PenghargaanObserver
{
    protected PenghargaanRepository $penghargaanRepository;

    public function __construct()
    {
        $this->penghargaanRepository = new PenghargaanRepository();
    }

    public function created(Penghargaan $penghargaan): void
    {
        $this->penghargaanRepository->clearCache();
    }

    public function updated(Penghargaan $penghargaan): void
    {
        $this->penghargaanRepository->clearCache();
    }

    public function deleted(Penghargaan $penghargaan): void
    {
        $this->penghargaanRepository->clearCache();
    }
}
