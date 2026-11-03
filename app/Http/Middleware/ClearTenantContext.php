<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->session()->forget([
            'tenant', 
            'active_kecamatan_id', 
            'active_perangkat_daerah_id'
        ]);

        return $next($request);
    }
}