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

    public function created(Budaya $budaya): void
    {
        $this->budayaRepository->clearCache();
    }

    public function updated(Budaya $budaya): void
    {
        $this->budayaRepository->clearCache();
    }

    public function deleted(Budaya $budaya): void
    {
        $this->budayaRepository->clearCache();
    }
}
