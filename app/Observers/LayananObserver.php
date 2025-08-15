<?php

namespace App\Observers;

use App\Models\Layanan;
use App\Repositories\LayananRepository;

class LayananObserver
{
    protected LayananRepository $layananRepository;

    public function __construct()
    {
        $this->layananRepository = new LayananRepository();
    }

    /**
     * Handle the Layanan "created" event.
     */
    public function created(Layanan $layanan): void
    {
        $this->layananRepository->clearCache();
    }

    /**
     * Handle the Layanan "updated" event.
     */
    public function updated(Layanan $layanan): void
    {
        $this->layananRepository->clearCache();
    }

    /**
     * Handle the Layanan "deleted" event.
     */
    public function deleted(Layanan $layanan): void
    {
        $this->layananRepository->clearCache();
    }
}
