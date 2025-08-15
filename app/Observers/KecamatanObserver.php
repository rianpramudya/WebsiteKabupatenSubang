<?php

namespace App\Observers;

use App\Models\Kecamatan;
use App\Repositories\SejarahRepository;

class KecamatanObserver
{
    protected SejarahRepository $sejarahRepository;

    /**
     * [FIX] Menggunakan dependency injection untuk mendapatkan instance repository.
     * Ini adalah cara yang lebih baik dan direkomendasikan oleh Laravel.
     */
    public function __construct(SejarahRepository $sejarahRepository)
    {
        $this->sejarahRepository = $sejarahRepository;
    }

    /**
     * Handle the Kecamatan "updated" event.
     * Membersihkan cache setiap kali data profil kecamatan diubah.
     */
    public function updated(Kecamatan $kecamatan): void
    {
        // Memanggil metode untuk membersihkan semua cache yang dikelola oleh SejarahRepository
        $this->sejarahRepository->clearCache();
    }

    /**
     * Handle the Kecamatan "deleted" event.
     */
    public function deleted(Kecamatan $kecamatan): void
    {
        $this->sejarahRepository->clearCache();
    }
}
