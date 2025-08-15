<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLayananRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LayananController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.layanan.' . $action;
        }
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.layanan.' . $action;
        }
        return 'admin.kabupaten.layanan.' . $action; // Fallback
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
        $this->authorize('viewAny', Layanan::class);
        $tenant = $this->getTenant($request);

        $query = Layanan::query();
        if (!$tenant && Auth::user()->hasRole('super-admin')) {
             $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $layanans = $query->orderBy('urutan')->paginate(10);
        
        return view('admin.layanan_CRUD.index', [
            'layanans' => $layanans,
            'tenant' => $tenant,
            'kecamatan' => ($tenant instanceof Kecamatan) ? $tenant : null,
            'perangkatDaerah' => ($tenant instanceof PerangkatDaerah) ? $tenant : null,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Layanan::class);
        $tenant = $this->getTenant($request);

        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.layanan_CRUD.create', [
            'layanan' => new Layanan(),
            'tenant' => $tenant,
            'kecamatan' => ($tenant instanceof Kecamatan) ? $tenant : null,
            'perangkatDaerah' => ($tenant instanceof PerangkatDaerah) ? $tenant : null,
            'kecamatans' => $kecamatans,
            'perangkatDaerahs' => $perangkatDaerahs,
        ]);
    }

    public function store(StoreLayananRequest $request) 
    {
        $this->authorize('create', Layanan::class);
        $tenant = $this->getTenant($request);
        
        $data = $request->validated();
        $user = Auth::user();
        $redirectTenant = $tenant;

        if ($user->hasRole('super-admin')) {
            if ($request->input('owner_type') == 'pd' && $request->filled('perangkat_daerah_id')) {
                $data['perangkat_daerah_id'] = $request->perangkat_daerah_id;
                $data['kecamatan_id'] = null;
                $redirectTenant = PerangkatDaerah::find($data['perangkat_daerah_id']);
            } elseif ($request->input('owner_type') == 'kecamatan' && $request->filled('kecamatan_id')) {
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

        Layanan::create($data);
        
        return redirect()->route($this->getRouteName($redirectTenant, 'index'), $this->getRouteParameters($redirectTenant))
                         ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($tenant, Layanan $layanan)
    {
        $this->authorize('update', $layanan);
        
        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.layanan_CRUD.edit', [
            'layanan' => $layanan,
            'tenant' => $tenant,
            'kecamatan' => ($tenant instanceof Kecamatan) ? $tenant : null,
            'perangkatDaerah' => ($tenant instanceof PerangkatDaerah) ? $tenant : null,
            'kecamatans' => $kecamatans,
            'perangkatDaerahs' => $perangkatDaerahs,
        ]);
    }

    public function update(StoreLayananRequest $request, $tenant, Layanan $layanan)
    {
        $this->authorize('update', $layanan);
        $data = $request->validated();
        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            if ($request->input('owner_type') == 'pd' && $request->filled('perangkat_daerah_id')) {
                $data['perangkat_daerah_id'] = $request->perangkat_daerah_id;
                $data['kecamatan_id'] = null;
            } elseif ($request->input('owner_type') == 'kecamatan' && $request->filled('kecamatan_id')) {
                $data['kecamatan_id'] = $request->kecamatan_id;
                $data['perangkat_daerah_id'] = null;
            } else {
                 $data['kecamatan_id'] = null;
                $data['perangkat_daerah_id'] = null;
            }
        } else {
            unset($data['kecamatan_id'], $data['perangkat_daerah_id']);
        }

        $layanan->update($data);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
                         ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($tenant, Layanan $layanan)
    {
        $this->authorize('delete', $layanan);
        
        $layanan->delete();
        
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
                         ->with('success', 'Layanan berhasil dihapus.');
    }
}
