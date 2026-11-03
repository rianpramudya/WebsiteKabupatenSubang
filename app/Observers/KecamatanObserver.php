<?php

namespace App\Observers;

use App\Models\Kecamatan;
use App\Repositories\SejarahRepository;

class KecamatanObserver
{
    protected SejarahRepository $sejarahRepository;

    public function __construct(SejarahRepository $sejarahRepository)
    {
        $this->sejarahRepository = $sejarahRepository;
    }

    public function updated(Kecamatan $kecamatan): void
    {

        $this->sejarahRepository->clearCache();
    }

    public function deleted(Kecamatan $kecamatan): void
    {
        $this->sejarahRepository->clearCache();
    }
}
