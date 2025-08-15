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

    /**
     * Handle the Sejarah "created" event.
     */
    public function created(Sejarah $sejarah): void
    {
        $this->sejarahRepository->clearCache();
    }

    /**
     * Handle the Sejarah "updated" event.
     */
    public function updated(Sejarah $sejarah): void
    {
        $this->sejarahRepository->clearCache();
    }

    /**
     * Handle the Sejarah "deleted" event.
     */
    public function deleted(Sejarah $sejarah): void
    {
        $this->sejarahRepository->clearCache();
    }
}
