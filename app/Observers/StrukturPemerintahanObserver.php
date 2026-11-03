<?php

namespace App\Observers;

use App\Models\Pejabat;
use App\Repositories\StrukturPemerintahanRepository;

class StrukturPemerintahanObserver
{
    protected StrukturPemerintahanRepository $strukturPemerintahanRepository;

    public function __construct()
    {
        $this->strukturPemerintahanRepository = new StrukturPemerintahanRepository();
    }

    public function created(Pejabat $pejabat): void
    {
        $this->strukturPemerintahanRepository->clearCache();
    }

    public function updated(Pejabat $pejabat): void
    {
        $this->strukturPemerintahanRepository->clearCache();
    }

    public function deleted(Pejabat $pejabat): void
    {
        $this->strukturPemerintahanRepository->clearCache();
    }
}
