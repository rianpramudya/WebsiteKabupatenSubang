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
    /**
     * Properti untuk menampung instance BeritaRepository.
     */
    protected BeritaRepository $beritaRepository;

    /**
     * Constructor untuk meng-inject BeritaRepository.
     */
    public function __construct(BeritaRepository $beritaRepository)
    {
        $this->beritaRepository = $beritaRepository;
    }

    /**
     * Menampilkan halaman daftar semua berita.
     */
    public function index(): View
    {
        // PERBAIKAN: Selalu bersihkan session di halaman indeks utama.
        session()->forget('origin_page_url');

        $beritas = $this->beritaRepository->getPaginatedForAll(9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => null,
            'judulHalaman' => 'Semua Berita'
        ]);
    }

    /**
     * [DIPERBAIKI] Menampilkan halaman detail untuk satu berita dengan logika view counter.
     */
    public function show(string $slug): View
    {
        $berita = $this->beritaRepository->findBySlug($slug);

        // ==================================================================
        // LOGIKA BARU UNTUK MENYIMPAN HALAMAN ASAL (ORIGIN) - LEBIH ROBUST
        // ==================================================================
        try {
            $previousUrl = \URL::previous();
            $requestForPrevious = app('request')->create($previousUrl);
            $previousRoute = app('router')->getRoutes()->match($requestForPrevious);

            // Daftar nama route yang dianggap sebagai "halaman portal" atau titik masuk yang valid.
            $portalRoutes = [
                'home',
                'kecamatan.show',
                'perangkat.show',
                'berita.kecamatan.index',
                'perangkat.berita.index',
                'berita.index',
            ];

            // Cek jika route sebelumnya valid dan ada dalam daftar.
            if ($previousRoute && in_array($previousRoute->getName(), $portalRoutes)) {
                // Jika halaman sebelumnya adalah portal atau indeks, atur URL asal.
                // Untuk 'home' dan 'berita.index', kita arahkan ke beranda utama.
                if (in_array($previousRoute->getName(), ['home', 'berita.index'])) {
                    session(['origin_page_url' => route('home')]);
                } else {
                    session(['origin_page_url' => $previousUrl]);
                }
            }
            // Jika route sebelumnya tidak ada dalam daftar (misalnya dari halaman detail berita lain),
            // jangan lakukan apa-apa, biarkan session yang ada tetap berlaku.
        } catch (\Exception $e) {
            // Tangani jika ada error saat mencocokkan route, pastikan session bersih.
            session()->forget('origin_page_url');
        }
        // ==================================================================

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


    /**
     * Mencatat jumlah pelihat.
     */
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

    /**
     * Menampilkan daftar berita untuk kecamatan tertentu.
     */
    public function indexKecamatan(Kecamatan $kecamatan): View
    {
        // PERBAIKAN: Selalu bersihkan session di halaman indeks kecamatan.
        session()->forget('origin_page_url');
        
        $beritas = $this->beritaRepository->getPaginatedForKecamatan($kecamatan, 9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => $kecamatan,
            'judulHalaman' => 'Berita Kecamatan ' . $kecamatan->name
        ]);
    }

    /**
     * Menampilkan daftar berita yang memiliki tag tertentu.
     */
    public function indexTag(string $slug): View
    {
        // PERBAIKAN: Selalu bersihkan session di halaman indeks tag.
        session()->forget('origin_page_url');

        $tag = Tag::where('slug->en', $slug)->firstOrFail();
        $beritas = $this->beritaRepository->getPaginatedForTag($tag, 9);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentKecamatan' => null,
            'judulHalaman' => 'Berita dengan Tag: ' . $tag->name
        ]);
    }

    /**
     * Mengunduh berita sebagai file PDF.
     */
    public function downloadPDF(Berita $berita)
    {
        $pdf = Pdf::loadView('berita.pdf', compact('berita'));
        $namaFile = $berita->slug . '.pdf';
        return $pdf->download($namaFile);
    }

    /**
     * Menampilkan daftar berita untuk sebuah Perangkat Daerah.
     */
    public function indexPerangkatDaerah(PerangkatDaerah $perangkatDaerah): View
    {
        // PERBAIKAN: Selalu bersihkan session di halaman indeks perangkat daerah.
        session()->forget('origin_page_url');

        $beritas = $this->beritaRepository->getPaginatedBeritaForPerangkatDaerah($perangkatDaerah, 12);

        return view('berita.index', [
            'beritas' => $beritas,
            'currentPerangkatDaerah' => $perangkatDaerah,
            'currentKecamatan' => null,
        ]);
    }
}
