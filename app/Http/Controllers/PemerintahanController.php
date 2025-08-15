<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Repositories\StrukturPemerintahanRepository;
use App\Repositories\PeranDanProgramRepository;
use App\Repositories\WilayahAdministrasiRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PemerintahanController extends Controller
{
    // ... (bagian __construct() Anda sudah benar, tidak perlu diubah) ...
    protected StrukturPemerintahanRepository $strukturPemerintahanRepository;
    protected PeranDanProgramRepository $peranDanProgramRepository;
    protected WilayahAdministrasiRepository $wilayahAdministrasiRepository;

    public function __construct(
        StrukturPemerintahanRepository $strukturPemerintahanRepository,
        PeranDanProgramRepository $peranDanProgramRepository,
        WilayahAdministrasiRepository $wilayahAdministrasiRepository
    ) {
        $this->strukturPemerintahanRepository = $strukturPemerintahanRepository;
        $this->peranDanProgramRepository = $peranDanProgramRepository;
        $this->wilayahAdministrasiRepository = $wilayahAdministrasiRepository;
    }

    /**
     * [DIPERBAIKI] Helper disederhanakan untuk mendapatkan konteks tenant.
     */
    private function getContext(Request $request): Kecamatan|PerangkatDaerah|null
    {
        return $request->route('perangkatDaerah') ?? $request->route('kecamatan');
    }

    public function struktur(Request $request): View
    {
        // ... (method ini sudah benar) ...
        $context = $this->getContext($request);
        $semua_pejabat = $this->strukturPemerintahanRepository->getAllPejabat($context);

        $semua_pejabat->each(function ($pejabat) {
            $pejabat->foto_url = $pejabat->foto
                ? asset('storage/' . $pejabat->foto)
                : 'https://placehold.co/300x300/e2e8f0/64748b?text=Foto';
        });

        $pimpinan = $semua_pejabat->filter(fn($p) => stripos($p->jabatan, 'bupati') !== false || stripos($p->jabatan, 'camat') !== false || stripos($p->jabatan, 'kepala dinas') !== false || stripos($p->jabatan, 'kepala badan') !== false);
        $sekretaris = $semua_pejabat->filter(fn($p) => stripos($p->jabatan, 'sekretaris') !== false);

        return view('pemerintahan.struktur', [
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
            'pimpinan' => $pimpinan,
            'sekretaris' => $sekretaris,
            'semua_pejabat' => $semua_pejabat
        ]);
    }

    public function peranDanProgram(Request $request): View
    {
        // ... (method ini sudah benar) ...
        $context = $this->getContext($request);
        $peran_dan_program = $this->peranDanProgramRepository->getAllPeranDanProgram($context);

        return view('pemerintahan.peran_dan_program', [
            'peran_dan_program' => $peran_dan_program,
            'currentKecamatan'  => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
        ]);
    }

    public function wilayahAdministrasi(Request $request): View
    {
        $context = $this->getContext($request);
        
        // [PERBAIKAN] Langsung gunakan relasi dari model untuk konsistensi
        if ($context) {
            $list_data = $context->wilayahAdministrasi()->orderBy('nama_desa')->get();
        } else {
            // Logika untuk Kabupaten (jika repository diperlukan)
            $list_data = $this->wilayahAdministrasiRepository->getWilayahAdministrasiData($context);
        }

        return view('pemerintahan.wilayah_administrasi', [
            'list_data'        => $list_data,
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
            'is_kabupaten'     => is_null($context),
        ]);
    }
}