<?php

namespace App\Observers;

use App\Models\Galeri;
use App\Repositories\GaleriRepository;

class GaleriObserver
{
    protected GaleriRepository $galeriRepository;

    public function __construct()
    {
        $this->galeriRepository = new GaleriRepository();
    }

    /**
     * Handle the Galeri "created" event.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return void
     */
    public function created(Galeri $galeri): void
    {
        $this->galeriRepository->clearCache();
    }

    /**
     * Handle the Galeri "deleted" event.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return void
     */
    public function deleted(Galeri $galeri): void
    {
        $this->galeriRepository->clearCache();
    }
}
