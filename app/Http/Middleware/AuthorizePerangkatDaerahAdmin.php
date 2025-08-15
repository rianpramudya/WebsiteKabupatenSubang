<?php

namespace App\Http\Middleware;

use App\Models\PerangkatDaerah; // <-- PASTIKAN MODEL DI-IMPORT
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

        // Langkah 1: Secara manual ubah parameter string (slug) menjadi objek Model.
        if ($perangkatDaerahParam instanceof PerangkatDaerah) {
            $perangkatDaerah = $perangkatDaerahParam;
        } elseif (is_string($perangkatDaerahParam)) {
            // Cari perangkat daerah berdasarkan slug. Gagal jika tidak ditemukan.
            $perangkatDaerah = PerangkatDaerah::where('slug', $perangkatDaerahParam)->firstOrFail();
            
            // Ganti parameter rute agar controller juga menerima objek, bukan string.
            $request->route()->setParameter('perangkatDaerah', $perangkatDaerah);
        }

        // Jika karena suatu alasan perangkat daerah tidak ditemukan, lanjutkan saja (akan 404).
        if (!$perangkatDaerah) {
            return $next($request);
        }

        try {
            // Langkah 2: Lakukan otorisasi dengan objek PerangkatDaerah yang sudah pasti ada.
            // Ini akan memanggil method 'manage' di PerangkatDaerahPolicy.
            Gate::authorize('manage', $perangkatDaerah);

        } catch (AuthorizationException $e) {
            // Langkah 3: Redirect dengan aman jika otorisasi gagal.
            return redirect()->route('perangkat.show', ['perangkatDaerah' => $perangkatDaerah->slug]);
        }

        // Jika otorisasi berhasil, lanjutkan ke controller.
        return $next($request);
    }
}
