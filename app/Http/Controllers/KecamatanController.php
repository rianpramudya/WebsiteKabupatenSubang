<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Agenda;
use App\Models\Layanan;
use App\Models\Berita;
use App\Repositories\AgendaRepository;
use App\Repositories\BeritaRepository;
use App\Repositories\BudayaRepository;
use App\Repositories\GaleriRepository;
use App\Repositories\LayananRepository;
use App\Repositories\ObjekWisataRepository;
use App\Repositories\StrukturPemerintahanRepository;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class KecamatanController extends Controller
{
    protected GaleriRepository $galeriRepository;
    protected AgendaRepository $agendaRepository;
    protected BudayaRepository $budayaRepository;
    protected ObjekWisataRepository $objekWisataRepository;
    protected LayananRepository $layananRepository;
    protected StrukturPemerintahanRepository $strukturPemerintahanRepository;
    protected BeritaRepository $beritaRepository;

    public function __construct(
        GaleriRepository $galeriRepository,
        AgendaRepository $agendaRepository,
        BudayaRepository $budayaRepository,
        ObjekWisataRepository $objekWisataRepository,
        LayananRepository $layananRepository,
        StrukturPemerintahanRepository $strukturPemerintahanRepository,
        BeritaRepository $beritaRepository
    ) {
        $this->galeriRepository = $galeriRepository;
        $this->agendaRepository = $agendaRepository;
        $this->budayaRepository = $budayaRepository;
        $this->objekWisataRepository = $objekWisataRepository;
        $this->layananRepository = $layananRepository;
        $this->strukturPemerintahanRepository = $strukturPemerintahanRepository;
        $this->beritaRepository = $beritaRepository;
    }

    public function show(Kecamatan $kecamatan): View
    {

        $beritaTerkini = $this->beritaRepository->getBeritaTerkiniForKecamatan($kecamatan, 5);

        $beritaPopuler = Cache::remember("berita.kecamatan.{$kecamatan->id}.populer.5", 300, function () use ($kecamatan) {
            return Berita::query()
                ->select(['id', 'judul', 'slug', 'views', 'published_at', 'kecamatan_id'])
                ->where('kecamatan_id', $kecamatan->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderByDesc('views')
                ->limit(5)
                ->get();
        });

        $agendasForCalendar = Agenda::query()
            ->select(['judul', 'tanggal_mulai', 'tanggal_selesai'])
            ->where('kecamatan_id', $kecamatan->id)

            ->whereBetween('tanggal_mulai', [now()->subYear(), now()->addYear()])
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        $agendaDataForJs = $agendasForCalendar->groupBy(function ($agenda) {
            return Carbon::parse($agenda->tanggal_mulai)->format('Y-m-d');
        })->map(function ($agendasOnDate) {
            return $agendasOnDate->map(function ($agenda) {
                $start = Carbon::parse($agenda->tanggal_mulai);
                $end = Carbon::parse($agenda->tanggal_selesai);

                $timeRange = $start->isoFormat('D MMM YYYY');
                if ($start->notEqualTo($end)) {
                    $timeRange .= ' - ' . $end->isoFormat('D MMM YYYY');
                }

                return [
                    'time'        => $timeRange,
                    'description' => $agenda->judul,
                ];
            })->values();
        });

        $agendasForDisplay = Agenda::query()
            ->select(['id', 'kecamatan_id', 'judul', 'tanggal_mulai', 'tanggal_selesai'])
            ->where('kecamatan_id', $kecamatan->id)
            ->whereDate('tanggal_mulai', '>=', today())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();

        $galeriFoto     = $this->galeriRepository->getLatestPhotosForKecamatan($kecamatan, 10);
        $galeriVideo    = $this->galeriRepository->getLatestVideosForKecamatan($kecamatan, 5);
        $budayaTerbaru  = $this->budayaRepository->getLatestForKecamatan($kecamatan, 3);
        $wisataUnggulan = $this->objekWisataRepository->getWisataUnggulanForKecamatan($kecamatan, 4);
        $layanans       = $this->layananRepository->getLayanansForKecamatan($kecamatan);
        $pejabats       = $this->strukturPemerintahanRepository->getAllPejabat($kecamatan);

        return view('kecamatan.show', [
            'currentKecamatan' => $kecamatan,
            'beritaTerkini'    => $beritaTerkini,
            'beritaPopuler'    => $beritaPopuler,
            'agendas'          => $agendasForDisplay,
            'agendaDataForJs'  => $agendaDataForJs,
            'galeriFoto'       => $galeriFoto,
            'galeriVideo'      => $galeriVideo,
            'layanans'         => $layanans,
            'pejabats'         => $pejabats,
            'wisataUnggulan'   => $wisataUnggulan,
            'budayaTerbaru'    => $budayaTerbaru,
        ]);
    }

    public function semuaAgenda(Kecamatan $kecamatan): View
    {
        $today = now()->startOfDay();

        $agendasHariIni = Agenda::query()
            ->where('kecamatan_id', $kecamatan->id)
            ->whereDate('tanggal_mulai', $today)
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        $agendasMendatang = Agenda::query()
            ->where('kecamatan_id', $kecamatan->id)
            ->where('tanggal_mulai', '>', $today->copy()->endOfDay())
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        $agendasLewat = Agenda::query()
            ->where('kecamatan_id', $kecamatan->id)
            ->where('tanggal_mulai', '<', $today)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('agenda.index', [
            'currentKecamatan'  => $kecamatan,
            'agendasHariIni'    => $agendasHariIni,
            'agendasMendatang'  => $agendasMendatang,
            'agendasLewat'      => $agendasLewat,
        ]);
    }

    public function galeriVideo(Kecamatan $kecamatan): View
    {
        $videos = $this->galeriRepository->getPaginatedVideosForKecamatan($kecamatan, 12);
        return view('galeri.video', [
            'currentKecamatan' => $kecamatan,
            'videos'           => $videos,
        ]);
    }

    public function galeriFoto(Kecamatan $kecamatan): View
    {
        $fotos = $this->galeriRepository->getPaginatedPhotosForKecamatan($kecamatan, 12);
        return view('galeri.foto', [
            'currentKecamatan' => $kecamatan,
            'fotos'            => $fotos,
        ]);
    }

    public function semuaLayanan(Kecamatan $kecamatan): View
    {
        $layanans = Layanan::query()
            ->where('kecamatan_id', $kecamatan->id)
            ->orderBy('nama', 'asc')
            ->paginate(9);

        return view('layanan.index', [
            'currentKecamatan' => $kecamatan,
            'layanans'         => $layanans,
        ]);
    }
}
