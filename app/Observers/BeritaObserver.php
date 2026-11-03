<?php

namespace App\Observers;

use App\Models\Berita;
use App\Repositories\BeritaRepository;

class BeritaObserver
{
    protected BeritaRepository $beritaRepository;

    public function __construct()
    {

        $this->beritaRepository = app(BeritaRepository::class);
    }

    public function saved(Berita $berita): void
    {
        $this->clearRelevantCache($berita);
    }

    public function deleted(Berita $berita): void
    {
        $this->clearRelevantCache($berita);
    }

    protected function clearRelevantCache(Berita $berita): void
    {

        if ($berita->kecamatan) {
            $this->beritaRepository->clearCacheForKecamatan($berita->kecamatan);
        }

        elseif ($berita->perangkatDaerah) {
            $this->beritaRepository->clearCacheForPerangkatDaerah($berita->perangkatDaerah);
        }

        else {
            $this->beritaRepository->clearCacheForAll();
        }
    }
}
