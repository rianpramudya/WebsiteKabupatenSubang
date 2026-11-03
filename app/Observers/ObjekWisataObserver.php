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

    public function created(ObjekWisata $objekWisata): void
    {
        $this->objekWisataRepository->clearCache();
    }

    public function updated(ObjekWisata $objekWisata): void
    {
        $this->objekWisataRepository->clearCache();
    }

    public function deleted(ObjekWisata $objekWisata): void
    {
        $this->objekWisataRepository->clearCache();
    }
}
