<?php

namespace App\Http\Middleware;

use App\Models\Kecamatan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeKecamatanAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $kecamatanParam = $request->route('kecamatan');
        $kecamatan = null;

        if ($kecamatanParam instanceof Kecamatan) {
            $kecamatan = $kecamatanParam;
        } elseif (is_string($kecamatanParam)) {

            $kecamatan = Kecamatan::where('slug', $kecamatanParam)->firstOrFail();

            $request->route()->setParameter('kecamatan', $kecamatan);
        }

        if (!$kecamatan) {
            return $next($request);
        }

        try {

            Gate::authorize('manage', $kecamatan);

        } catch (AuthorizationException $e) {

            return redirect()->route('kecamatan.show', ['kecamatan' => $kecamatan->slug]);
        }

        return $next($request);
    }
}
