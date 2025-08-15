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

    /**
     * Handle the Hotel "created" event.
     */
    public function created(Hotel $hotel): void
    {
        $this->hotelRepository->clearCache();
    }

    /**
     * Handle the Hotel "updated" event.
     */
    public function updated(Hotel $hotel): void
    {
        $this->hotelRepository->clearCache();
    }

    /**
     * Handle the Hotel "deleted" event.
     */
    public function deleted(Hotel $hotel): void
    {
        $this->hotelRepository->clearCache();
    }
}
