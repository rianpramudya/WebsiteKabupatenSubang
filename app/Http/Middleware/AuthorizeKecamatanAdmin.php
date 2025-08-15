<?php

namespace App\Http\Middleware;

use App\Models\Kecamatan; // <-- PASTIKAN MODEL DI-IMPORT
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

        // Langkah 1: Secara manual ubah parameter string (slug) menjadi objek Model.
        if ($kecamatanParam instanceof Kecamatan) {
            $kecamatan = $kecamatanParam;
        } elseif (is_string($kecamatanParam)) {
            // Cari kecamatan berdasarkan slug. Gagal jika tidak ditemukan.
            $kecamatan = Kecamatan::where('slug', $kecamatanParam)->firstOrFail();
            
            // Ganti parameter rute agar controller juga menerima objek, bukan string.
            $request->route()->setParameter('kecamatan', $kecamatan);
        }

        // Jika karena suatu alasan kecamatan tidak ditemukan, lanjutkan saja (akan 404).
        if (!$kecamatan) {
            return $next($request);
        }

        try {
            // Langkah 2: Lakukan otorisasi dengan objek Kecamatan yang sudah pasti ada.
            Gate::authorize('manage', $kecamatan);

        } catch (AuthorizationException $e) {
            // Langkah 3: Redirect dengan aman karena $kecamatan sudah pasti objek.
            return redirect()->route('kecamatan.show', ['kecamatan' => $kecamatan->slug]);
        }

        // Jika otorisasi berhasil, lanjutkan ke controller.
        return $next($request);
    }
}
