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

    public function created(Layanan $layanan): void
    {
        $this->layananRepository->clearCache();
    }

    public function updated(Layanan $layanan): void
    {
        $this->layananRepository->clearCache();
    }

    public function deleted(Layanan $layanan): void
    {
        $this->layananRepository->clearCache();
    }
}
