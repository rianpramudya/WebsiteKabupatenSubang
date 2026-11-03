<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Repositories\BeritaRepository;
use Illuminate\Http\Request;

class BeritaTerkiniComposer
{
    protected $beritaRepository;
    protected $request;

    public function __construct(BeritaRepository $beritaRepository, Request $request)
    {
        $this->beritaRepository = $beritaRepository;
        $this->request = $request;
    }

    public function compose(View $view)
    {
        $beritaTerkini = collect();
        $limit = 5;

        $kecamatan = $this->request->route('kecamatan');
        $perangkatDaerah = $this->request->route('perangkatDaerah');

        if ($perangkatDaerah) {
            $beritaTerkini = $this->beritaRepository->getBeritaTerkiniForPerangkatDaerah($perangkatDaerah, $limit);
        } elseif ($kecamatan) {
            $beritaTerkini = $this->beritaRepository->getBeritaTerkiniForKecamatan($kecamatan, $limit);
        } else {
            $beritaTerkini = \App\Models\Berita::query()
                ->whereNull('kecamatan_id')
                ->whereNull('perangkat_daerah_id')
                ->latest('published_at')
                ->take($limit)
                ->get();
        }

        $view->with('berita_terkini', $beritaTerkini);
    }
}