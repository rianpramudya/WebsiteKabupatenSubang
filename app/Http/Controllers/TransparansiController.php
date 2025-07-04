<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuangan;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransparansiController extends Controller
{
    /**
     * Menampilkan halaman Transparansi Keuangan untuk Kabupaten atau Kecamatan.
     */
    public function index(Request $request): View
    {
        $laporanQuery = LaporanKeuangan::query()->orderBy('created_at', 'desc');
        $namaWilayah = 'Kabupaten Subang';
        $kecamatan = null;

        // Periksa jika ini rute kecamatan
        if ($request->routeIs('transparansi.kecamatan')) {
            $slug = $request->route('slug'); // Ambil slug dari URL

            $tenant = Tenant::where('slug', $slug)->first();
            if (!$tenant) {
                abort(404, 'Kecamatan tidak ditemukan.');
            }

            $laporanQuery->where('tenant_id', $tenant->id);
            $namaWilayah = 'Kecamatan ' . $tenant->name;
            $kecamatan = $tenant;
        } else {
            $laporanQuery->whereNull('tenant_id');
        }

        // Group by tahun dan urutkan tahun dan isi dalam tahun secara descending
        $laporanPerTahun = $laporanQuery->get()
            ->groupBy('tahun')
            ->sortKeysDesc()
            ->map(function ($laporans) {
                return $laporans->sortByDesc('created_at');
            });

        return view('transparansi_keuangan.index', [
            'nama_wilayah' => $namaWilayah,
            'laporan_per_tahun' => $laporanPerTahun,
            'kecamatan' => $kecamatan,
        ]);
    }
}
