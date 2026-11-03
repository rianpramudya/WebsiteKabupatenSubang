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

    public function created(Infografis $infografis): void
    {
        $this->infografisRepository->clearCache();
    }

    public function updated(Infografis $infografis): void
    {
        $this->infografisRepository->clearCache();
    }

    public function deleted(Infografis $infografis): void
    {
        $this->infografisRepository->clearCache();
    }
}
