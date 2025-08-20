<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDaerah;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Repositories\AgendaRepository;
use App\Repositories\BeritaRepository;
use App\Repositories\GaleriRepository;
use App\Repositories\LayananRepository;
use App\Repositories\StrukturPemerintahanRepository;
use Carbon\Carbon;
use Illuminate\View\View;

class PerangkatController extends Controller
{
    // ... (properti dan constructor tetap sama) ...
    protected GaleriRepository $galeriRepository;
    protected AgendaRepository $agendaRepository;
    protected LayananRepository $layananRepository;
    protected StrukturPemerintahanRepository $strukturPemerintahanRepository;
    protected BeritaRepository $beritaRepository;

    public function __construct(
        GaleriRepository $galeriRepository,
        AgendaRepository $agendaRepository,
        LayananRepository $layananRepository,
        StrukturPemerintahanRepository $strukturPemerintahanRepository,
        BeritaRepository $beritaRepository
    ) {
        $this->galeriRepository = $galeriRepository;
        $this->agendaRepository = $agendaRepository;
        $this->layananRepository = $layananRepository;
        $this->strukturPemerintahanRepository = $strukturPemerintahanRepository;
        $this->beritaRepository = $beritaRepository;
    }


    /**
     * Halaman beranda publik sebuah Perangkat Daerah.
     */
    public function show(PerangkatDaerah $perangkatDaerah): View
    {
        // ======================================================================
        // === PERBAIKAN UTAMA ADA DI SINI ======================================
        // ======================================================================
        // Ambil berita terkini dan populer melalui Repository agar cache berfungsi.
        $beritaTerkini = $this->beritaRepository->getBeritaTerkiniForPerangkatDaerah($perangkatDaerah, 5);
        $beritaPopuler = $this->beritaRepository->getBeritaPopulerForPerangkatDaerah($perangkatDaerah, 5);

        // Query agenda khusus untuk kalender
        $agendasForCalendar = Agenda::query()
            ->where('perangkat_daerah_id', $perangkatDaerah->id)
            ->whereBetween('tanggal_mulai', [now()->subYear(), now()->addYear()])
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        // Siapkan data untuk JavaScript
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
                return ['time' => $timeRange, 'description' => $agenda->judul];
            })->values();
        });

        // Ambil 3 agenda terdekat
        $agendasForDisplay = Agenda::query()
            ->where('perangkat_daerah_id', $perangkatDaerah->id)
            ->whereDate('tanggal_mulai', '>=', today())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(3)
            ->get();

        // Ganti semua placeholder dengan query atau repository call yang benar
        $galeriFoto     = $this->galeriRepository->getLatestPhotosForPerangkatDaerah($perangkatDaerah, 10);
        $galeriVideo    = $this->galeriRepository->getLatestVideosForPerangkatDaerah($perangkatDaerah, 5);
        $layanans       = $this->layananRepository->getLayanansForPerangkatDaerah($perangkatDaerah);
        $pejabats       = $this->strukturPemerintahanRepository->getAllPejabat($perangkatDaerah);

        // Budaya & Wisata kemungkinan tidak relevan untuk Perangkat Daerah, jadi biarkan kosong
        $budayaTerbaru  = collect();
        $wisataUnggulan = collect();

        // Kirim semua data ke view 'perangkat.show'
        return view('perangkat.show', [
            'currentPerangkatDaerah' => $perangkatDaerah,
            'beritaTerkini'          => $beritaTerkini,
            'beritaPopuler'          => $beritaPopuler,
            'agendas'                => $agendasForDisplay,
            'agendaDataForJs'        => $agendaDataForJs,
            'galeriFoto'             => $galeriFoto,
            'galeriVideo'            => $galeriVideo,
            'layanans'               => $layanans,
            'pejabats'               => $pejabats,
            'wisataUnggulan'         => $wisataUnggulan,
            'budayaTerbaru'          => $budayaTerbaru,
        ]);
    }

    // ... (metode lainnya tetap sama) ...
    public function galeriVideo(PerangkatDaerah $perangkatDaerah): View
    {
        $videos = Galeri::where('perangkat_daerah_id', $perangkatDaerah->id)
            ->whereIn('tipe', ['video_yt', 'video_upload'])
            ->latest()
            ->paginate(12);

        return view('galeri.video', [
            'videos' => $videos,
            'activePerangkatDaerah' => $perangkatDaerah,
            'currentPerangkatDaerah' => $perangkatDaerah,
        ]);
    }

    public function galeriFoto(PerangkatDaerah $perangkatDaerah): View
    {
        $fotos = Galeri::where('perangkat_daerah_id', $perangkatDaerah->id)
            ->where('tipe', 'foto')
            ->latest()
            ->paginate(16);

        return view('galeri.foto', [
            'fotos' => $fotos,
            'currentPerangkatDaerah' => $perangkatDaerah,
        ]);
    }

    public function semuaLayanan(PerangkatDaerah $perangkatDaerah): View
    {
        $layanans = Layanan::query()
            ->where('perangkat_daerah_id', $perangkatDaerah->id)
            ->orderBy('urutan', 'asc')
            ->paginate(9);

        return view('layanan.index', [
            'currentPerangkatDaerah' => $perangkatDaerah,
            'layanans' => $layanans,
            'currentKecamatan' => null,
        ]);
    }

    public function detailLayanan(PerangkatDaerah $perangkatDaerah, Layanan $layanan): View
    {
        if ($layanan->perangkat_daerah_id !== $perangkatDaerah->id) {
            abort(404);
        }

        return view('layanan.show', [
            'currentPerangkatDaerah' => $perangkatDaerah,
            'layanan' => $layanan,
            'currentKecamatan' => null,
        ]);
    }
}
