<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Repositories\PenghargaanRepository;
use App\Repositories\SejarahRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
    protected PenghargaanRepository $penghargaanRepository;
    protected SejarahRepository $sejarahRepository;

    public function __construct(
        PenghargaanRepository $penghargaanRepository,
        SejarahRepository $sejarahRepository
    ) {
        $this->penghargaanRepository = $penghargaanRepository;
        $this->sejarahRepository = $sejarahRepository;
    }

    private function getProfilData(Request $request): Model
    {
        $tenant = $request->route('kecamatan') ?? $request->route('perangkatDaerah');
        if ($tenant) {
            return $tenant;
        }

        return Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
    }

    public function sejarah(Request $request): View
    {
        $profilData = $this->getProfilData($request);
        $sejarah_items = $this->sejarahRepository->getSejarahItems($profilData);

        $navContext = $request->route('kecamatan') ?? $request->route('perangkatDaerah');

        return view('profil.sejarah', [
            'profil'                 => $profilData,
            'sejarah_items'          => $sejarah_items,
            'currentKecamatan'       => ($navContext instanceof Kecamatan) ? $navContext : null,
            'currentPerangkatDaerah' => ($navContext instanceof PerangkatDaerah) ? $navContext : null,
        ]);
    }

    public function wilayah(Request $request): View
    {
        $profilData = $this->getProfilData($request);
        $navContext = $request->route('kecamatan') ?? $request->route('perangkatDaerah');

        return view('profil.wilayah', [
            'tenant'                 => $profilData,
            'currentKecamatan'       => ($navContext instanceof Kecamatan) ? $navContext : null,
            'currentPerangkatDaerah' => ($navContext instanceof PerangkatDaerah) ? $navContext : null,
        ]);
    }

    public function visiMisi(Request $request): View
    {
        $profilData = $this->getProfilData($request);
        $navContext = $request->route('kecamatan') ?? $request->route('perangkatDaerah');

        return view('profil.visi_misi', [
            'profil'                 => $profilData,
            'currentKecamatan'       => ($navContext instanceof Kecamatan) ? $navContext : null,
            'currentPerangkatDaerah' => ($navContext instanceof PerangkatDaerah) ? $navContext : null,
        ]);
    }

    public function penghargaan(Request $request): View
    {
        $profilData = $this->getProfilData($request);
        $navContext = $request->route('kecamatan') ?? $request->route('perangkatDaerah');
        $penghargaan_per_tahun = $this->penghargaanRepository->getGroupedByYear($profilData);

        return view('profil.penghargaan', [
            'penghargaan_per_tahun' => $penghargaan_per_tahun,
            'currentKecamatan'      => ($navContext instanceof Kecamatan) ? $navContext : null,
            'currentPerangkatDaerah' => ($navContext instanceof PerangkatDaerah) ? $navContext : null,
        ]);
    }
}
