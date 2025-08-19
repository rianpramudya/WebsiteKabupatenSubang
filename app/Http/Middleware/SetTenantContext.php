<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        Session::forget(['active_kecamatan_id', 'active_perangkat_daerah_id']);

        if ($perangkatDaerahParam = $request->route('perangkatDaerah')) {
            $perangkatDaerahInstance = $perangkatDaerahParam instanceof PerangkatDaerah
                ? $perangkatDaerahParam
                : PerangkatDaerah::where('slug', $perangkatDaerahParam)->first();

            if ($perangkatDaerahInstance) {
                Session::put('active_perangkat_daerah_id', $perangkatDaerahInstance->id);
                $request->route()->setParameter('perangkatDaerah', $perangkatDaerahInstance);
            }
        }
        elseif ($kecamatanParam = $request->route('kecamatan')) {
            $kecamatanInstance = $kecamatanParam instanceof Kecamatan
                ? $kecamatanParam
                : Kecamatan::where('slug', $kecamatanParam)->first();

            if ($kecamatanInstance) {
                Session::put('active_kecamatan_id', $kecamatanInstance->id);
                $request->route()->setParameter('kecamatan', $kecamatanInstance);
            }
        }

        return $next($request);
    }
}