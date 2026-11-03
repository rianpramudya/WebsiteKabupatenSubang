<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Kecamatan;

class BlockKabupatenSlug
{

    public function handle(Request $request, Closure $next): Response
    {

        $kecamatanParam = $request->route('kecamatan');

        if ($kecamatanParam instanceof Kecamatan && $kecamatanParam->slug === 'kabupaten-subang') {
            abort(404);
        }

        return $next($request);
    }
}