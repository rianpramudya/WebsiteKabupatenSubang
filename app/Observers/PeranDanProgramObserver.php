<?php

namespace App\Observers;

use App\Models\PeranDanProgram;
use App\Repositories\PeranDanProgramRepository;

class PeranDanProgramObserver
{
    protected PeranDanProgramRepository $peranDanProgramRepository;

    public function __construct()
    {
        $this->peranDanProgramRepository = new PeranDanProgramRepository();
    }

    /**
     * Handle the PeranDanProgram "created" event.
     */
    public function created(PeranDanProgram $peranDanProgram): void
    {
        $this->peranDanProgramRepository->clearCache();
    }

    /**
     * Handle the PeranDanProgram "updated" event.
     */
    public function updated(PeranDanProgram $peranDanProgram): void
    {
        $this->peranDanProgramRepository->clearCache();
    }

    /**
     * Handle the PeranDanProgram "deleted" event.
     */
    public function deleted(PeranDanProgram $peranDanProgram): void
    {
        $this->peranDanProgramRepository->clearCache();
    }
}
