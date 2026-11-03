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

        $kabupaten = Kecamatan::where('slug', 'kabupaten-subang')->first();

        return view('portal', compact(
            'beritaTerkini',
            'kecamatans',
            'perangkatDaerahs',
            'kabupaten'
        ));
    }
}