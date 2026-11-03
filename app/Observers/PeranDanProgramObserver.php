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

    public function created(PeranDanProgram $peranDanProgram): void
    {
        $this->peranDanProgramRepository->clearCache();
    }

    public function updated(PeranDanProgram $peranDanProgram): void
    {
        $this->peranDanProgramRepository->clearCache();
    }

    public function deleted(PeranDanProgram $peranDanProgram): void
    {
        $this->peranDanProgramRepository->clearCache();
    }
}
