<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Kecamatan;

class BlockKabupatenSlug
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil parameter 'kecamatan' dari rute
        $kecamatanParam = $request->route('kecamatan');

        // Jika parameter ada dan slug-nya adalah 'kabupaten-subang', tampilkan 404
        if ($kecamatanParam instanceof Kecamatan && $kecamatanParam->slug === 'kabupaten-subang') {
            abort(404);
        }

        return $next($request);
    }
}