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

    /**
     * Handle the Penghargaan "created" event.
     */
    public function created(Penghargaan $penghargaan): void
    {
        $this->penghargaanRepository->clearCache();
    }

    /**
     * Handle the Penghargaan "updated" event.
     */
    public function updated(Penghargaan $penghargaan): void
    {
        $this->penghargaanRepository->clearCache();
    }

    /**
     * Handle the Penghargaan "deleted" event.
     */
    public function deleted(Penghargaan $penghargaan): void
    {
        $this->penghargaanRepository->clearCache();
    }
}
