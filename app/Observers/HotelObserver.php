<?php

namespace App\Observers;

use App\Models\Hotel;
use App\Repositories\HotelRepository;

class HotelObserver
{
    protected HotelRepository $hotelRepository;

    public function __construct()
    {
        $this->hotelRepository = new HotelRepository();
    }

    public function created(Hotel $hotel): void
    {
        $this->hotelRepository->clearCache();
    }

    public function updated(Hotel $hotel): void
    {
        $this->hotelRepository->clearCache();
    }

    public function deleted(Hotel $hotel): void
    {
        $this->hotelRepository->clearCache();
    }
}
