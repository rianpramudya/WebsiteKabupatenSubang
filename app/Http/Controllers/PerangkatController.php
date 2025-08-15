<?php

namespace App\Http\Controllers;

// Ganti model utama ke PerangkatDaerah
use App\Models\PerangkatDaerah;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\Galeri; 

// Impor semua repository yang dibutuhkan, sama seperti KecamatanController
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

class PerangkatController extends Controller
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

    /**
     * Halaman beranda publik sebuah Perangkat Daerah.
     */
    public function show(PerangkatDaerah $perangkatDaerah): View
    {
        // Ambil 5 berita terbaru untuk perangkat daerah ini
        $beritaTerkini = Berita::query()
            ->where('perangkat_daerah_id', $perangkatDaerah->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(5)
            ->get();

        // Populer: gunakan cache singkat (5 menit)
        $cacheKey = "berita.perangkat.{$perangkatDaerah->id}.populer.5";
        $beritaPopuler = Cache::remember($cacheKey, 300, function () use ($perangkatDaerah) {
            return Berita::query()
                ->where('perangkat_daerah_id', $perangkatDaerah->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderByDesc('views')
                ->limit(5)
                ->get();
        });

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

    /**
     * Halaman daftar video untuk Perangkat Daerah.
     */
   public function galeriVideo(PerangkatDaerah $perangkatDaerah): View
    {
        // PERBAIKAN: Gunakan 'whereIn' untuk mencari semua tipe video ('video_yt' dan 'video_upload').
        $videos = Galeri::where('perangkat_daerah_id', $perangkatDaerah->id)
                          ->whereIn('tipe', ['video_yt', 'video_upload']) // <-- PERUBAHAN DI SINI
                          ->latest() // Urutkan berdasarkan yang terbaru
                          ->paginate(12);

        return view('galeri.video', [
            'videos' => $videos,
            'activePerangkatDaerah' => $perangkatDaerah, // Kirim konteks perangkat daerah ke view
            'currentPerangkatDaerah' => $perangkatDaerah, // Untuk konsistensi dengan composer
        ]);
    }

    public function galeriFoto(PerangkatDaerah $perangkatDaerah): View
    {
        // Query untuk mengambil semua foto milik Perangkat Daerah ini
        $fotos = Galeri::where('perangkat_daerah_id', $perangkatDaerah->id)
                         ->where('tipe', 'foto') // Filter untuk hanya mendapatkan foto
                         ->latest() // Urutkan berdasarkan yang terbaru
                         ->paginate(16); // Tampilkan 16 foto per halaman

        return view('galeri.foto', [
            'fotos' => $fotos,
            'currentPerangkatDaerah' => $perangkatDaerah,
        ]);
    }


    /**
     * [BARU] Menampilkan halaman daftar semua layanan untuk Perangkat Daerah.
     */
    public function semuaLayanan(PerangkatDaerah $perangkatDaerah): View
    {
        $layanans = Layanan::query()
            ->where('perangkat_daerah_id', $perangkatDaerah->id)
            ->orderBy('urutan', 'asc')
            ->paginate(9);

        return view('layanan.index', [
            'currentPerangkatDaerah' => $perangkatDaerah,
            'layanans' => $layanans,
            'currentKecamatan' => null, // Menghindari error di view
        ]);
    }

    /**
     * [BARU] Menampilkan halaman detail untuk satu layanan.
     */
    public function detailLayanan(PerangkatDaerah $perangkatDaerah, Layanan $layanan): View
    {
        // Pastikan layanan yang diakses benar-benar milik perangkat daerah yang ada di URL
        if ($layanan->perangkat_daerah_id !== $perangkatDaerah->id) {
            abort(404);
        }

        return view('layanan.show', [
            'currentPerangkatDaerah' => $perangkatDaerah,
            'layanan' => $layanan,
            'currentKecamatan' => null, // Menghindari error di view
        ]);
    }
}
