<?php

namespace App\Observers;

use App\Models\Berita;
use App\Repositories\BeritaRepository;

class BeritaObserver
{
    protected BeritaRepository $beritaRepository;

    public function __construct()
    {
        $this->beritaRepository = new BeritaRepository();
    }

    /**
     * Membersihkan cache setelah berita disimpan (dibuat atau diupdate).
     */
    public function saved(Berita $berita): void
    {
        // Pastikan berita punya kecamatan sebelum membersihkan cache
        if ($berita->kecamatan) {
            $this->beritaRepository->clearCacheForKecamatan($berita->kecamatan);
        }
    }

    /**
     * Membersihkan cache setelah berita dihapus.
     */
    public function deleted(Berita $berita): void
    {
        if ($berita->kecamatan) {
            $this->beritaRepository->clearCacheForKecamatan($berita->kecamatan);
        }
    }

    
}