<?php

namespace App\Observers;

use App\Models\Sejarah;
use App\Repositories\SejarahRepository;

class SejarahObserver
{
    protected SejarahRepository $sejarahRepository;

    public function __construct()
    {
        $this->sejarahRepository = new SejarahRepository();
    }

    public function created(Sejarah $sejarah): void
    {
        $this->sejarahRepository->clearCache();
    }

    public function updated(Sejarah $sejarah): void
    {
        $this->sejarahRepository->clearCache();
    }

    public function deleted(Sejarah $sejarah): void
    {
        $this->sejarahRepository->clearCache();
    }
}
