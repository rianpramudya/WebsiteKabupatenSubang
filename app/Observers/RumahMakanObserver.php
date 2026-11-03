<?php

namespace App\Observers;

use App\Models\RumahMakan;
use App\Repositories\RumahMakanRepository;

class RumahMakanObserver
{
    protected RumahMakanRepository $rumahMakanRepository;

    public function __construct()
    {
        $this->rumahMakanRepository = new RumahMakanRepository();
    }

    public function created(RumahMakan $rumahMakan): void
    {
        $this->rumahMakanRepository->clearCache();
    }

    public function updated(RumahMakan $rumahMakan): void
    {
        $this->rumahMakanRepository->clearCache();
    }

    public function deleted(RumahMakan $rumahMakan): void
    {
        $this->rumahMakanRepository->clearCache();
    }
}
