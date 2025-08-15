<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Cache;

class NavigationComposer
{
    public function compose(View $view)
    {
        $activeKecamatan = null;
        $activePerangkatDaerah = null;
        $isSuperAdmin = Auth::check() && Auth::user()->hasRole('super-admin');
        $currentRoute = request()->route();

        // [PERBAIKAN] Logika penentuan konteks tenant disempurnakan
        if ($currentRoute) {
            $kecamatanParam = $currentRoute->parameter('kecamatan');
            $perangkatDaerahParam = $currentRoute->parameter('perangkatDaerah');

            // Cek Perangkat Daerah terlebih dahulu
            if ($perangkatDaerahParam instanceof PerangkatDaerah) {
                $activePerangkatDaerah = $perangkatDaerahParam;
            }
            // Cek Kecamatan, TAPI pastikan BUKAN slug 'kabupaten-subang'
            elseif ($kecamatanParam instanceof Kecamatan && $kecamatanParam->slug !== 'kabupaten-subang') {
                $activeKecamatan = $kecamatanParam;
            }
        }

        // Cek fallback dari data view, juga dengan pengecualian untuk 'kabupaten-subang'
        if (!$activeKecamatan && isset($view->currentKecamatan) && $view->currentKecamatan instanceof Kecamatan && $view->currentKecamatan->slug !== 'kabupaten-subang') {
            $activeKecamatan = $view->currentKecamatan;
        }

        if (!$activePerangkatDaerah && isset($view->currentPerangkatDaerah) && $view->currentPerangkatDaerah instanceof PerangkatDaerah) {
            $activePerangkatDaerah = $view->currentPerangkatDaerah;
        }

        $isKecamatanContext = (bool)$activeKecamatan;
        $isPerangkatDaerahContext = (bool)$activePerangkatDaerah;
        $kecamatanSlug = $activeKecamatan ? $activeKecamatan->slug : null;
        $perangkatDaerahSlug = $activePerangkatDaerah ? $activePerangkatDaerah->slug : null;
        $logoHomeUrl = $isSuperAdmin ? route('dashboard') : route('home');

        // Logika URL Beranda (sudah diperbaiki sebelumnya dan tetap dipertahankan)
        $publicHomeUrl = route('home');
        if ($isKecamatanContext) {
            $publicHomeUrl = route('kecamatan.show', ['kecamatan' => $kecamatanSlug]);
        } elseif ($isPerangkatDaerahContext) {
            $publicHomeUrl = route('perangkat.show', ['perangkatDaerah' => $perangkatDaerahSlug]);
        } elseif ($isSuperAdmin) {
            $publicHomeUrl = route('dashboard');
        }

        // Statistik (placeholder)
        $visitorStats = ['online' => 0, 'today' => 0, 'total' => 0];

        // Ambil data kontak Kabupaten Subang (sudah benar)
        $kontakKabupaten = Cache::remember('kontak_kabupaten', now()->addHours(24), function () {
            return Kecamatan::where('slug', 'kabupaten-subang')->first();
        });

        $view->with(compact(
            'activeKecamatan',
            'activePerangkatDaerah',
            'isSuperAdmin',
            'isKecamatanContext',
            'isPerangkatDaerahContext',
            'kecamatanSlug',
            'perangkatDaerahSlug',
            'logoHomeUrl',
            'publicHomeUrl',
            'visitorStats',
            'kontakKabupaten'
        ));
    }
}
