<?php
namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Berita;
use App\Repositories\InfografisRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InfoGrafisController extends Controller
{
    protected InfografisRepository $infografisRepository;

    public function __construct(InfografisRepository $infografisRepository)
    {
        $this->infografisRepository = $infografisRepository;
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
        $beritaQuery = Berita::query()->latest('published_at')->take(5);

        if ($context instanceof PerangkatDaerah) {
            $infografis = $this->infografisRepository->getPaginatedForPerangkatDaerah($context);
            $berita_terkini = $beritaQuery->where('perangkat_daerah_id', $context->id)->get();
        } elseif ($context instanceof Kecamatan) {
            $infografis = $this->infografisRepository->getPaginatedForKecamatan($context);
            $berita_terkini = $beritaQuery->where('kecamatan_id', $context->id)->get();
        } else {
            $infografis = $this->infografisRepository->getPaginatedForKabupaten();
            $berita_terkini = $beritaQuery->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id')->get();
        }

        return view('info_grafis.index', [
            'infografis'       => $infografis,
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
            'berita_terkini'   => $berita_terkini,
        ]);
    }
}
