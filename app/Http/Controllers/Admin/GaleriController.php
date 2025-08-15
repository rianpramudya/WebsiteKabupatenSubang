<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGaleriRequest;
use App\Models\Galeri;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class GaleriController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.galeri.' . $action;
        }
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.galeri.' . $action;
        }
        return 'admin.kabupaten.galeri.' . $action; // Fallback
    }

    private function getRouteParameters(?Model $tenant): array
    {
        if ($tenant instanceof Kecamatan) {
            return ['kecamatan' => $tenant->slug];
        }
        if ($tenant instanceof PerangkatDaerah) {
            return ['perangkatDaerah' => $tenant->slug];
        }
        return [];
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Galeri::class);
        $tenant = $this->getTenant($request);

        $query = Galeri::query();
        if (!$tenant && Auth::user()->hasRole('super-admin')) {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $galeris = $query->latest()->paginate(12);

        return view('admin.galeri_CRUD.index', [
            'galeris' => $galeris,
            'tenant' => $tenant,
            'kecamatan' => ($tenant instanceof Kecamatan) ? $tenant : null,
            'perangkatDaerah' => ($tenant instanceof PerangkatDaerah) ? $tenant : null,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Galeri::class);
        $tenant = $this->getTenant($request);
        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.galeri_CRUD.create', [
            'tenant' => $tenant,
            'kecamatan' => ($tenant instanceof Kecamatan) ? $tenant : null,
            'perangkatDaerah' => ($tenant instanceof PerangkatDaerah) ? $tenant : null,
            'kecamatans' => $kecamatans,
            'perangkatDaerahs' => $perangkatDaerahs,
        ]);
    }

    public function store(StoreGaleriRequest $request)
    {
        $this->authorize('create', Galeri::class);
        $tenant = $this->getTenant($request);
        $data = $request->validated();
        $user = Auth::user();

        // [FIX] Menambahkan logika untuk 'video_upload'
        if ($data['tipe'] === 'foto' && $request->hasFile('file_foto')) {
            $data['file_url'] = $request->file('file_foto')->store('images/galeri', 'public');
        } elseif ($data['tipe'] === 'video_upload' && $request->hasFile('file_video_upload')) {
            $data['file_url'] = $request->file('file_video_upload')->store('videos/galeri', 'public');
        } elseif ($data['tipe'] === 'video_yt') {
            $data['file_url'] = $this->convertYoutubeUrl($data['file_video_yt']);
        }

        $redirectTenant = $tenant;
        if ($user->hasRole('super-admin')) {
            if ($request->owner_type == 'pd' && $request->filled('perangkat_daerah_id')) {
                $data['perangkat_daerah_id'] = $request->perangkat_daerah_id;
                $data['kecamatan_id'] = null;
                $redirectTenant = PerangkatDaerah::find($data['perangkat_daerah_id']);
            } elseif ($request->owner_type == 'kecamatan' && $request->filled('kecamatan_id')) {
                $data['kecamatan_id'] = $request->kecamatan_id;
                $data['perangkat_daerah_id'] = null;
                $redirectTenant = Kecamatan::find($data['kecamatan_id']);
            } else {
                $data['kecamatan_id'] = null;
                $data['perangkat_daerah_id'] = null;
                $redirectTenant = null;
            }
        } else {
            if ($tenant instanceof Kecamatan) {
                $data['kecamatan_id'] = $tenant->id;
            } elseif ($tenant instanceof PerangkatDaerah) {
                $data['perangkat_daerah_id'] = $tenant->id;
            }
        }

        Galeri::create($data);

        return redirect()->route($this->getRouteName($redirectTenant, 'index'), $this->getRouteParameters($redirectTenant))
            ->with('success', 'Media berhasil ditambahkan.');
    }

    public function destroy($tenant, Galeri $galeri)
    {
        $this->authorize('delete', $galeri);

        // [FIX] Menambahkan logika untuk menghapus file 'video_upload'
        if (in_array($galeri->tipe, ['foto', 'video_upload']) && $galeri->file_url) {
            Storage::disk('public')->delete($galeri->file_url);
        }
        
        $galeri->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Media berhasil dihapus.');
    }

    private function convertYoutubeUrl(?string $url): ?string
    {
        if (!$url) return null;
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url;
    }
}
