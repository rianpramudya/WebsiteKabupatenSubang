<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Repositories\LaporanKeuanganRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransparansiController extends Controller
{
    protected LaporanKeuanganRepository $laporanKeuanganRepository;

    public function __construct(LaporanKeuanganRepository $laporanKeuanganRepository)
    {
        $this->laporanKeuanganRepository = $laporanKeuanganRepository;
    }

    private function getContext(Request $request): Kecamatan|PerangkatDaerah|null
    {
        if ($request->route('perangkatDaerah') instanceof PerangkatDaerah) {
            return $request->route('perangkatDaerah');
        }
        $kecamatanParam = $request->route('kecamatan');
        if ($kecamatanParam instanceof Kecamatan) {
            return $kecamatanParam;
        }
        if (is_string($kecamatanParam)) {
            return Kecamatan::where('slug', $kecamatanParam)->first();
        }
        return null;
    }

    public function index(Request $request): View
    {
        $context = $this->getContext($request);

        $laporanPerTahun = $this->laporanKeuanganRepository->getGroupedByYear($context);

        return view('transparansi_keuangan.index', [
            'laporan_per_tahun' => $laporanPerTahun,
            'currentKecamatan'  => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
        ]);
    }
}
