<?php

namespace App\Observers;

use App\Models\Pejabat;
use App\Repositories\StrukturPemerintahanRepository;

class StrukturPemerintahanObserver // <-- NAMA KELAS DIUBAH
{
    protected StrukturPemerintahanRepository $strukturPemerintahanRepository;

    public function __construct()
    {
        $this->strukturPemerintahanRepository = new StrukturPemerintahanRepository();
    }

    /**
     * Handle the Pejabat "created" event.
     */
    public function created(Pejabat $pejabat): void
    {
        $this->strukturPemerintahanRepository->clearCache();
    }

    /**
     * Handle the Pejabat "updated" event.
     */
    public function updated(Pejabat $pejabat): void
    {
        $this->strukturPemerintahanRepository->clearCache();
    }

    /**
     * Handle the Pejabat "deleted" event.
     */
    public function deleted(Pejabat $pejabat): void
    {
        $this->strukturPemerintahanRepository->clearCache();
    }
}
