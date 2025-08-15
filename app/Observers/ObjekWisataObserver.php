<?php

namespace App\Observers;

use App\Models\ObjekWisata;
use App\Repositories\ObjekWisataRepository;

class ObjekWisataObserver
{
    protected ObjekWisataRepository $objekWisataRepository;

    public function __construct()
    {
        $this->objekWisataRepository = new ObjekWisataRepository();
    }

    /**
     * Handle the ObjekWisata "created" event.
     */
    public function created(ObjekWisata $objekWisata): void
    {
        $this->objekWisataRepository->clearCache();
    }

    /**
     * Handle the ObjekWisata "updated" event.
     */
    public function updated(ObjekWisata $objekWisata): void
    {
        $this->objekWisataRepository->clearCache();
    }

    /**
     * Handle the ObjekWisata "deleted" event.
     */
    public function deleted(ObjekWisata $objekWisata): void
    {
        $this->objekWisataRepository->clearCache();
    }
}
