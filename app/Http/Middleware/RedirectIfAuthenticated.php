<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /** @var \App\Models\User $user */
                $user = Auth::guard($guard)->user();

                if ($user->hasRole('super-admin')) {
                    return redirect(route('dashboard'));
                }

                if ($user->hasRole('admin-perangkat-daerah') && $user->perangkatDaerah) {
                    return redirect(route('perangkat.show', ['perangkatDaerah' => $user->perangkatDaerah->slug]));
                }

                if ($user->hasRole('admin-kecamatan') && $user->kecamatan) {
                    return redirect(route('kecamatan.show', ['kecamatan' => $user->kecamatan->slug]));
                }

                return redirect(route('home'));
            }
        }

        return $next($request);
    }
}
