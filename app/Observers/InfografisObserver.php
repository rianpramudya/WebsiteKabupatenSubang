<?php

namespace App\Observers;

use App\Models\Infografis;
use App\Repositories\InfografisRepository;

class InfografisObserver
{
    protected InfografisRepository $infografisRepository;

    public function __construct()
    {
        $this->infografisRepository = new InfografisRepository();
    }

    /**
     * Handle the Infografis "created" event.
     */
    public function created(Infografis $infografis): void
    {
        $this->infografisRepository->clearCache();
    }

    /**
     * Handle the Infografis "updated" event.
     */
    public function updated(Infografis $infografis): void
    {
        $this->infografisRepository->clearCache();
    }

    /**
     * Handle the Infografis "deleted" event.
     */
    public function deleted(Infografis $infografis): void
    {
        $this->infografisRepository->clearCache();
    }
}
