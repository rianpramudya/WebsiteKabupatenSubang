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

    /**
     * Handle the RumahMakan "created" event.
     */
    public function created(RumahMakan $rumahMakan): void
    {
        $this->rumahMakanRepository->clearCache();
    }

    /**
     * Handle the RumahMakan "updated" event.
     */
    public function updated(RumahMakan $rumahMakan): void
    {
        $this->rumahMakanRepository->clearCache();
    }

    /**
     * Handle the RumahMakan "deleted" event.
     */
    public function deleted(RumahMakan $rumahMakan): void
    {
        $this->rumahMakanRepository->clearCache();
    }
}
