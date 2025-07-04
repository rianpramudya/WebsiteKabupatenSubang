<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Budaya;
use App\Models\Kecamatan;
use App\Models\ObjekWisata; // <- Pastikan ini diimpor!
use App\Models\Hotel;
use App\Models\RumahMakan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WisataController extends Controller
{
    public function seniDanBudaya(Request $request, $slug = null): View
    {
        $query = Budaya::query()->whereNotNull('published_at')->latest('published_at');
        $beritaQuery = Berita::query()->latest()->take(5);
        $nama_wilayah = 'Kabupaten Subang';
        $kecamatan = null;

        if ($slug) {
            $kecamatan = Kecamatan::where('slug', $slug)->firstOrFail();
            $query->where('kecamatan_id', $kecamatan->id);
            $beritaQuery->where('kecamatan_id', $kecamatan->id);
            $nama_wilayah = 'Kecamatan ' . $kecamatan->name;
        } else {
            $query->whereNull('kecamatan_id');
            $beritaQuery->whereNull('kecamatan_id');
        }

        // Logika Pencarian
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $budayas = $query->paginate(5); // Menampilkan 5 item per halaman
        $berita_terkini = $beritaQuery->get();

        return view('wisata.seni_dan_budaya', compact(
            'budayas',
            'berita_terkini',
            'nama_wilayah',
            'kecamatan'
        ));
    }

    public function objekWisata(Request $request, $slug = null): View
    {
        $query = ObjekWisata::query()->orderBy('is_unggulan', 'desc')->orderBy('nama', 'asc');
        $nama_wilayah = 'Kabupaten Subang';
        $kecamatan = null;

        if ($slug) {
            $kecamatan = Kecamatan::where('slug', $slug)->firstOrFail();
            $query->where('kecamatan_id', $kecamatan->id);
            $nama_wilayah = 'Kecamatan ' . $kecamatan->name;
        } else {
            $query->whereNull('kecamatan_id');
        }

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Logika Filter Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $objek_wisatas = $query->paginate(9)->withQueryString(); // Menampilkan 9 item per halaman

        // Ambil semua kategori unik untuk filter dropdown
        $kategori_filter = ObjekWisata::select('kategori')->distinct()->pluck('kategori');

        return view('wisata.objek_wisata', compact(
            'objek_wisatas',
            'nama_wilayah',
            'kecamatan',
            'kategori_filter'
        ));
    }

    public function hotel(Request $request, $slug = null): View
    {
        $query = Hotel::query()->whereNotNull('published_at')->latest('published_at');
        $beritaQuery = Berita::query()->latest()->take(5);
        $nama_wilayah = 'Kabupaten Subang';
        $kecamatan = null;

        if ($slug) {
            $kecamatan = Kecamatan::where('slug', $slug)->firstOrFail();
            $query->where('kecamatan_id', $kecamatan->id);
            $beritaQuery->where('kecamatan_id', $kecamatan->id);
            $nama_wilayah = 'Kecamatan ' . $kecamatan->name;
        } else {
            $query->whereNull('kecamatan_id');
            $beritaQuery->whereNull('kecamatan_id');
        }

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $hotels = $query->paginate(5)->withQueryString();
        $berita_terkini = $beritaQuery->get();

        return view('wisata.hotel', compact(
            'hotels',
            'berita_terkini',
            'nama_wilayah',
            'kecamatan'
        ));
    }

    public function rumahMakan(Request $request, $slug = null): View
    {
        $query = RumahMakan::query()->whereNotNull('published_at')->latest('published_at');
        $beritaQuery = Berita::query()->latest()->take(5);
        $nama_wilayah = 'Kabupaten Subang';
        $kecamatan = null;

        if ($slug) {
            $kecamatan = Kecamatan::where('slug', $slug)->firstOrFail();
            $query->where('kecamatan_id', $kecamatan->id);
            $beritaQuery->where('kecamatan_id', $kecamatan->id);
            $nama_wilayah = 'Kecamatan ' . $kecamatan->name;
        } else {
            $query->whereNull('kecamatan_id');
            $beritaQuery->whereNull('kecamatan_id');
        }

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $rumah_makans = $query->paginate(5)->withQueryString();
        $berita_terkini = $beritaQuery->get();

        return view('wisata.rumah_makan', compact(
            'rumah_makans',
            'berita_terkini',
            'nama_wilayah',
            'kecamatan'
        ));
    }
}
