<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah; // <-- Ditambahkan
use App\Models\Layanan;
use Illuminate\Http\Request;

class PublicLayananController extends Controller
{
    /**
     * [MODIFIKASI]
     * Menampilkan halaman detail untuk satu layanan.
     * Method ini sekarang menangani rute dari Kecamatan dan Perangkat Daerah.
     */
    public function show($tenant, Layanan $layanan)
    {
        // Variabel $tenant sekarang secara otomatis berisi model Kecamatan atau Perangkat Daerah dari URL.

        // 1. Validasi kepemilikan layanan
        $isOwner = false;
        if ($tenant instanceof Kecamatan && $layanan->kecamatan_id === $tenant->id) {
            $isOwner = true;
        } elseif ($tenant instanceof PerangkatDaerah && $layanan->perangkat_daerah_id === $tenant->id) {
            $isOwner = true;
        }

        // 2. Jika layanan tidak dimiliki oleh konteks URL yang diakses, tampilkan 404.
        if (!$isOwner) {
            abort(404);
        }

        // 3. Siapkan variabel untuk view agar tetap kompatibel
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        $perangkatDaerah = ($tenant instanceof PerangkatDaerah) ? $tenant : null;

        return view('layanan.layanan-detail', [
            'layanan' => $layanan,
            'currentKecamatan' => $kecamatan,
            'currentPerangkatDaerah' => $perangkatDaerah,
        ]);
    }
}
