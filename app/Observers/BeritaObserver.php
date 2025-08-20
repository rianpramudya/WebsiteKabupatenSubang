<?php

namespace App\Observers;

use App\Models\Berita;
use App\Repositories\BeritaRepository;

class BeritaObserver
{
    protected BeritaRepository $beritaRepository;

    public function __construct()
    {
        // Menggunakan dependency injection Laravel untuk mendapatkan instance yang benar
        $this->beritaRepository = app(BeritaRepository::class);
    }

    /**
     * Membersihkan cache setelah berita disimpan (dibuat atau diupdate).
     */
    public function saved(Berita $berita): void
    {
        $this->clearRelevantCache($berita);
    }

    /**
     * Membersihkan cache setelah berita dihapus.
     */
    public function deleted(Berita $berita): void
    {
        $this->clearRelevantCache($berita);
    }

    /**
     * Logika terpusat untuk membersihkan cache yang relevan.
     */
    protected function clearRelevantCache(Berita $berita): void
    {
        // Jika berita milik kecamatan, bersihkan cache kecamatan.
        if ($berita->kecamatan) {
            $this->beritaRepository->clearCacheForKecamatan($berita->kecamatan);
        }
        // Jika berita milik perangkat daerah, bersihkan cache perangkat daerah.
        elseif ($berita->perangkatDaerah) {
            $this->beritaRepository->clearCacheForPerangkatDaerah($berita->perangkatDaerah);
        }
        // Jika tidak keduanya (milik kabupaten), bersihkan cache global.
        else {
            $this->beritaRepository->clearCacheForAll();
        }
    }
}
