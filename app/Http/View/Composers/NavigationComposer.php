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

        if ($currentRoute) {
            $kecamatanParam = $currentRoute->parameter('kecamatan');
            $perangkatDaerahParam = $currentRoute->parameter('perangkatDaerah');

            if ($perangkatDaerahParam instanceof PerangkatDaerah) {
                $activePerangkatDaerah = $perangkatDaerahParam;
            }

            elseif ($kecamatanParam instanceof Kecamatan && $kecamatanParam->slug !== 'kabupaten-subang') {
                $activeKecamatan = $kecamatanParam;
            }
        }

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

        $publicHomeUrl = route('home');
        if ($isKecamatanContext) {
            $publicHomeUrl = route('kecamatan.show', ['kecamatan' => $kecamatanSlug]);
        } elseif ($isPerangkatDaerahContext) {
            $publicHomeUrl = route('perangkat.show', ['perangkatDaerah' => $perangkatDaerahSlug]);
        } elseif ($isSuperAdmin) {
            $publicHomeUrl = route('dashboard');
        }

        $visitorStats = ['online' => 0, 'today' => 0, 'total' => 0];

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
