<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Layanan;
use Illuminate\Http\Request;

class PublicLayananController extends Controller
{

    public function show($tenant, Layanan $layanan)
    {

        $isOwner = false;
        if ($tenant instanceof Kecamatan && $layanan->kecamatan_id === $tenant->id) {
            $isOwner = true;
        } elseif ($tenant instanceof PerangkatDaerah && $layanan->perangkat_daerah_id === $tenant->id) {
            $isOwner = true;
        }

        if (!$isOwner) {
            abort(404);
        }

        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        $perangkatDaerah = ($tenant instanceof PerangkatDaerah) ? $tenant : null;

        return view('layanan.layanan-detail', [
            'layanan' => $layanan,
            'currentKecamatan' => $kecamatan,
            'currentPerangkatDaerah' => $perangkatDaerah,
        ]);
    }
}
