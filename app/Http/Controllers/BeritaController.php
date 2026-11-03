<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Repositories\BeritaRepository;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Tags\Tag;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\URL;

class BeritaController extends Controller
{

    protected BeritaRepository $beritaRepository;

    public function __construct(BeritaRepository $beritaRepository)
    {
        $this->beritaRepository = $beritaRepository;
    }

    public function index(): View
    {
        session()->forget('origin_page_url');

        $beritas = $this->beritaRepository->getPaginatedForAll(9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => null,
            'judulHalaman' => 'Semua Berita'
        ]);
    }

    public function show(string $slug): View
    {
        $berita = $this->beritaRepository->findBySlug($slug);

        try {
            $previousUrl = \URL::previous();
            $requestForPrevious = app('request')->create($previousUrl);
            $previousRoute = app('router')->getRoutes()->match($requestForPrevious);

            $portalRoutes = [
                'home',
                'kecamatan.show',
                'perangkat.show',
                'berita.kecamatan.index',
                'perangkat.berita.index',
                'berita.index',
            ];

            if ($previousRoute && in_array($previousRoute->getName(), $portalRoutes)) {

                if (in_array($previousRoute->getName(), ['home', 'berita.index'])) {
                    session(['origin_page_url' => route('home')]);
                } else {
                    session(['origin_page_url' => $previousUrl]);
                }
            }

        } catch (\Exception $e) {

            session()->forget('origin_page_url');
        }

        $this->recordView($berita);
        $beritaTerkait = $this->beritaRepository->getRelatedBerita($berita);
        $berita->refresh();

        return view('berita.show', [
            'berita' => $berita,
            'beritaTerkait' => $beritaTerkait,
            'currentKecamatan' => $berita->kecamatan,
            'currentPerangkatDaerah' => $berita->perangkatDaerah,
        ]);
    }

    protected function recordView(Berita $berita): void
    {
        $agent = new Agent();
        if ($agent->isRobot()) {
            return;
        }

        $viewedPosts = Session::get('viewed_posts', []);

        if (!in_array($berita->id, $viewedPosts)) {
            $berita->increment('views');
            Session::push('viewed_posts', $berita->id);
        }
    }

    public function indexKecamatan(Kecamatan $kecamatan): View
    {
        session()->forget('origin_page_url');

        $beritas = $this->beritaRepository->getPaginatedForKecamatan($kecamatan, 9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => $kecamatan,
            'judulHalaman' => 'Berita Kecamatan ' . $kecamatan->name
        ]);
    }

    public function indexTag(string $slug): View
    {
        session()->forget('origin_page_url');

        $tag = Tag::where('slug->en', $slug)->firstOrFail();
        $beritas = $this->beritaRepository->getPaginatedForTag($tag, 9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => null,
            'judulHalaman' => 'Berita dengan Tag: ' . $tag->name
        ]);
    }

    public function downloadPDF(Berita $berita)
    {
        $pdf = Pdf::loadView('berita.pdf', compact('berita'));
        $namaFile = $berita->slug . '.pdf';
        return $pdf->download($namaFile);
    }

    public function indexPerangkatDaerah(PerangkatDaerah $perangkatDaerah): View
    {
        session()->forget('origin_page_url');

        $beritas = $this->beritaRepository->getPaginatedBeritaForPerangkatDaerah($perangkatDaerah, 12);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentPerangkatDaerah' => $perangkatDaerah,
            'currentKecamatan' => null,
        ]);
    }

    public function indexTagKecamatan(Kecamatan $kecamatan, string $slug): View
    {
        session()->forget('origin_page_url');
        $tag = Tag::where('slug->en', $slug)->firstOrFail();
        $beritas = $this->beritaRepository->getPaginatedForTagAndKecamatan($tag, $kecamatan, 9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => $kecamatan,
            'judulHalaman' => 'Berita Kecamatan ' . $kecamatan->name . ' dengan Tag: ' . $tag->name,
        ]);
    }

    public function indexTagPerangkatDaerah(PerangkatDaerah $perangkatDaerah, string $slug): View
    {
        session()->forget('origin_page_url');
        $tag = Tag::where('slug->en', $slug)->firstOrFail();
        $beritas = $this->beritaRepository->getPaginatedForTagAndPerangkatDaerah($tag, $perangkatDaerah, 9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentPerangkatDaerah' => $perangkatDaerah,
            'currentKecamatan' => null,
            'judulHalaman' => 'Berita ' . $perangkatDaerah->name . ' dengan Tag: ' . $tag->name,
        ]);
    }
}
