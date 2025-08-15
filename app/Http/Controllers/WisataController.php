<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use App\Models\Berita;
use App\Repositories\BudayaRepository;
use App\Repositories\HotelRepository;
use App\Repositories\ObjekWisataRepository;
use App\Repositories\RumahMakanRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WisataController extends Controller
{
    protected BudayaRepository $budayaRepository;
    protected HotelRepository $hotelRepository;
    protected ObjekWisataRepository $objekWisataRepository;
    protected RumahMakanRepository $rumahMakanRepository;

    public function __construct(
        BudayaRepository $budayaRepository,
        HotelRepository $hotelRepository,
        ObjekWisataRepository $objekWisataRepository,
        RumahMakanRepository $rumahMakanRepository
    ) {
        $this->budayaRepository = $budayaRepository;
        $this->hotelRepository = $hotelRepository;
        $this->objekWisataRepository = $objekWisataRepository;
        $this->rumahMakanRepository = $rumahMakanRepository;
    }

    /**
     * [BARU] Helper function terpusat untuk mendapatkan konteks.
     */
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

    /**
     * [MODIFIKASI] Helper untuk berita terkini yang sadar konteks.
     */
    private function getBeritaTerkini(Kecamatan|PerangkatDaerah|null $context)
    {
        $query = Berita::query()->latest('published_at')->take(5);

        if ($context instanceof PerangkatDaerah) {
            return $query->where('perangkat_daerah_id', $context->id)->get();
        }
        if ($context instanceof Kecamatan) {
            return $query->where('kecamatan_id', $context->id)->get();
        }
        
        return $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id')->get();
    }

    public function seniDanBudaya(Request $request): View
    {
        $context = $this->getContext($request);
        
        if ($context instanceof PerangkatDaerah) {
            $budayas = $this->budayaRepository->getPaginatedForPerangkatDaerah($context);
        } elseif ($context instanceof Kecamatan) {
            $budayas = $this->budayaRepository->getPaginatedForKecamatan($context);
        } else {
            $budayas = $this->budayaRepository->getPaginatedForKabupaten();
        }

        return view('wisata.seni_dan_budaya', [
            'budayas'          => $budayas,
            'berita_terkini'   => $this->getBeritaTerkini($context),
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
        ]);
    }

    public function objekWisata(Request $request): View
    {
        $context = $this->getContext($request);

        if ($context instanceof PerangkatDaerah) {
            $objek_wisatas = $this->objekWisataRepository->getPaginatedForPerangkatDaerah($context, $request);
        } elseif ($context instanceof Kecamatan) {
            $objek_wisatas = $this->objekWisataRepository->getPaginatedForKecamatan($context, $request);
        } else {
            $objek_wisatas = $this->objekWisataRepository->getPaginatedForKabupaten($request);
        }

        return view('wisata.objek_wisata', [
            'objek_wisatas'    => $objek_wisatas,
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
            'kategori_filter'  => $this->objekWisataRepository->getKategoriList(),
        ]);
    }

    public function hotel(Request $request): View
    {
        $context = $this->getContext($request);
        
        if ($context instanceof PerangkatDaerah) {
            $hotels = $this->hotelRepository->getPaginatedForPerangkatDaerah($context, $request);
        } elseif ($context instanceof Kecamatan) {
            $hotels = $this->hotelRepository->getPaginatedForKecamatan($context, $request);
        } else {
            $hotels = $this->hotelRepository->getPaginatedForKabupaten($request);
        }

        return view('wisata.hotel', [
            'hotels'           => $hotels,
            'berita_terkini'   => $this->getBeritaTerkini($context),
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
        ]);
    }

    public function rumahMakan(Request $request): View
    {
        $context = $this->getContext($request);

        if ($context instanceof PerangkatDaerah) {
            $rumah_makans = $this->rumahMakanRepository->getPaginatedForPerangkatDaerah($context, $request);
        } elseif ($context instanceof Kecamatan) {
            $rumah_makans = $this->rumahMakanRepository->getPaginatedForKecamatan($context, $request);
        } else {
            $rumah_makans = $this->rumahMakanRepository->getPaginatedForKabupaten($request);
        }
        
        return view('wisata.rumah_makan', [
            'rumah_makans'     => $rumah_makans,
            'berita_terkini'   => $this->getBeritaTerkini($context),
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
        ]);
    }
}
