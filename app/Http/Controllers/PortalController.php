<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Berita;
use App\Models\Agenda;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PortalController extends Controller
{

    public function index(): View
    {

        $kecamatans = Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get();
        $beritaTerkini = Berita::with('kategori')->latest('published_at')->take(6)->get();

        $perangkatDaerahs = PerangkatDaerah::orderBy('name')->get();

        $kabupaten = Kecamatan::where('slug', 'kabupaten-subang')->first();

        return view('portal', [
            'kecamatans'       => $kecamatans,
            'beritaTerkini'    => $beritaTerkini,
            'perangkatDaerahs' => $perangkatDaerahs,
            'kabupaten'        => $kabupaten,
            'currentKecamatan' => null,
        ]);
    }

    public function agenda(Request $request): View
    {
        $perangkatDaerah = $request->route('perangkatDaerah');
        $kecamatanParam = $request->route('kecamatan');
        $context = null;

        if ($perangkatDaerah instanceof PerangkatDaerah) {
            $context = $perangkatDaerah;
        } elseif ($kecamatanParam instanceof Kecamatan) {
            $context = $kecamatanParam;
        } elseif (is_string($kecamatanParam)) {
            $context = Kecamatan::where('slug', $kecamatanParam)->first();
        }

        $today = Carbon::today();
        $query = Agenda::query();

        if ($context instanceof PerangkatDaerah) {

            $query->where('perangkat_daerah_id', $context->id);
        } elseif ($context instanceof Kecamatan) {

            $query->where('kecamatan_id', $context->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $allAgendas = $query->orderBy('tanggal_mulai', 'asc')->get();

        $agendasHariIni = $allAgendas->filter(function ($agenda) use ($today) {
            $mulai = Carbon::parse($agenda->tanggal_mulai);
            $selesai = $agenda->tanggal_selesai ? Carbon::parse($agenda->tanggal_selesai) : $mulai;
            return $today->between($mulai, $selesai);
        });

        $agendasMendatang = $allAgendas->filter(fn($agenda) => Carbon::parse($agenda->tanggal_mulai)->isFuture());

        $agendasLewat = $allAgendas->filter(function ($agenda) use ($today) {
            $selesai = $agenda->tanggal_selesai ? Carbon::parse($agenda->tanggal_selesai) : Carbon::parse($agenda->tanggal_mulai);
            return $selesai->isPast() && !$today->between(Carbon::parse($agenda->tanggal_mulai), $selesai);
        })->sortByDesc('tanggal_mulai');

        return view('agenda.index', [
            'currentKecamatan' => ($context instanceof Kecamatan) ? $context : null,
            'currentPerangkatDaerah' => ($context instanceof PerangkatDaerah) ? $context : null,
            'agendasHariIni' => $agendasHariIni,
            'agendasMendatang' => $agendasMendatang,
            'agendasLewat' => $agendasLewat,
        ]);
    }
}
