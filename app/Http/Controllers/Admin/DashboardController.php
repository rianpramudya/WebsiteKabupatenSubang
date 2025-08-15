<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;

class DashboardController extends Controller
{
    public function index()
    {
        $beritaTerkini = Berita::latest()->take(6)->get();
        $kecamatans = Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get();
        $perangkatDaerahs = PerangkatDaerah::orderBy('name')->get();

        // [DITAMBAHKAN] Ambil data spesifik Kabupaten untuk banner dan info lainnya.
        $kabupaten = Kecamatan::where('slug', 'kabupaten-subang')->first();

        // Kirim semua variabel yang dibutuhkan ke view.
        return view('portal', compact(
            'beritaTerkini', 
            'kecamatans', 
            'perangkatDaerahs', 
            'kabupaten' // <-- Pastikan variabel ini ditambahkan
        ));
    }
}