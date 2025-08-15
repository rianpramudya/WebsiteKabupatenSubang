<?php

namespace App\Observers;

use App\Models\Budaya;
use App\Repositories\BudayaRepository;

class BudayaObserver
{
    protected BudayaRepository $budayaRepository;

    public function __construct()
    {
        $this->budayaRepository = new BudayaRepository();
    }

    /**
     * Handle the Budaya "created" event.
     */
    public function created(Budaya $budaya): void
    {
        $this->budayaRepository->clearCache();
    }

    /**
     * Handle the Budaya "updated" event.
     */
    public function updated(Budaya $budaya): void
    {
        $this->budayaRepository->clearCache();
    }

    /**
     * Handle the Budaya "deleted" event.
     */
    public function deleted(Budaya $budaya): void
    {
        $this->budayaRepository->clearCache();
    }
}
