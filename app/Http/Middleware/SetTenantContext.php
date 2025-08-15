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
    /**
     * Handle an incoming request.
     * Middleware terpadu ini akan mendeteksi konteks tenant (Kecamatan atau Perangkat Daerah)
     * dan menyimpannya ke dalam session untuk digunakan oleh bagian lain dari aplikasi,
     * seperti TenantScope atau View Composers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Selalu bersihkan konteks sebelumnya untuk menghindari data tumpang tindih
        // saat berpindah dari halaman kecamatan ke perangkat daerah atau sebaliknya.
        Session::forget(['active_kecamatan_id', 'active_perangkat_daerah_id']);

        // Prioritas 1: Cek apakah ada parameter 'perangkatDaerah' di rute.
        if ($perangkatDaerahParam = $request->route('perangkatDaerah')) {
            
            // Jika parameter sudah berupa objek Model, gunakan langsung.
            // Jika masih berupa string (slug), cari di database.
            $perangkatDaerahInstance = $perangkatDaerahParam instanceof PerangkatDaerah
                ? $perangkatDaerahParam
                : PerangkatDaerah::where('slug', $perangkatDaerahParam)->first();

            if ($perangkatDaerahInstance) {
                // Set session untuk Perangkat Daerah dengan kunci yang benar.
                Session::put('active_perangkat_daerah_id', $perangkatDaerahInstance->id);

                // ======================================================================
                // PERBAIKAN KRUSIAL:
                // "Serahkan" objek Model ini ke dalam request agar Controller bisa menerimanya.
                // Tanpa baris ini, controller akan menerima null.
                // ======================================================================
                $request->route()->setParameter('perangkatDaerah', $perangkatDaerahInstance);
            }
        }
        // Prioritas 2: Jika tidak ada konteks Perangkat Daerah, cek parameter 'kecamatan'.
        elseif ($kecamatanParam = $request->route('kecamatan')) {

            // Logika yang sama untuk kecamatan.
            $kecamatanInstance = $kecamatanParam instanceof Kecamatan
                ? $kecamatanParam
                : Kecamatan::where('slug', $kecamatanParam)->first();

            if ($kecamatanInstance) {
                // Set session untuk Kecamatan dengan kunci yang benar.
                Session::put('active_kecamatan_id', $kecamatanInstance->id);
                
                // Lakukan hal yang sama untuk kecamatan.
                $request->route()->setParameter('kecamatan', $kecamatanInstance);
            }
        }

        // Lanjutkan request ke controller atau middleware berikutnya.
        return $next($request);
    }
}
