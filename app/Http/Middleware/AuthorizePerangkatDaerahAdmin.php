<?php

namespace App\Http\Middleware;

use App\Models\PerangkatDaerah;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

class AuthorizePerangkatDaerahAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $perangkatDaerahParam = $request->route('perangkatDaerah');
        $perangkatDaerah = null;

        if ($perangkatDaerahParam instanceof PerangkatDaerah) {
            $perangkatDaerah = $perangkatDaerahParam;
        } elseif (is_string($perangkatDaerahParam)) {

            $perangkatDaerah = PerangkatDaerah::where('slug', $perangkatDaerahParam)->firstOrFail();

            $request->route()->setParameter('perangkatDaerah', $perangkatDaerah);
        }

        if (!$perangkatDaerah) {
            return $next($request);
        }

        try {

            Gate::authorize('manage', $perangkatDaerah);

        } catch (AuthorizationException $e) {

            return redirect()->route('perangkat.show', ['perangkatDaerah' => $perangkatDaerah->slug]);
        }

        return $next($request);
    }
}
