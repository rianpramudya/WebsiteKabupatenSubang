<?php

namespace App\Http\Controllers;

use App\Models\Infografis;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Berita;

class InfoGrafisController extends Controller
{
    public function index(Request $request, $slug = null): View
{
    $query = Infografis::query()->whereNotNull('published_at')->latest('published_at');
    $nama_wilayah = 'Kabupaten Subang';
    $kecamatan = null;

    if ($slug) {
        $kecamatan = Kecamatan::where('slug', $slug)->firstOrFail();
        $query->where('kecamatan_id', $kecamatan->id);
        $nama_wilayah = 'Kecamatan ' . $kecamatan->name;
    } else {
        $query->whereNull('kecamatan_id');
    }

    $infografis = $query->paginate(12); // Menampilkan 12 item per halaman

    // 🔥 Ambil 5 berita terkini, kontekstual dengan kecamatan bila ada
    $berita_terkini = Berita::query()
        ->latest()
        ->when($kecamatan, function ($q) use ($kecamatan) {
            $q->where('kecamatan_id', $kecamatan->id);
        }, function ($q) {
            $q->whereNull('kecamatan_id');
        })
        ->take(5)
        ->get();

    return view('info_grafis.index', compact(
        'infografis',
        'nama_wilayah',
        'kecamatan',
        'berita_terkini' // <- ini yang penting!
    ));
}

}
