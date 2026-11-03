<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PenghargaanController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            return 'admin.kecamatan.profil.penghargaan.' . $action;
        }
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.profil.penghargaan.' . $action;
        }

        return 'admin.kabupaten.profil.penghargaan.' . $action;
    }

    private function getRouteParameters(?Model $tenant): array
    {
        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            return ['kecamatan' => $tenant->slug];
        }
        if ($tenant instanceof PerangkatDaerah) {
            return ['perangkatDaerah' => $tenant->slug];
        }

        return [];
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Penghargaan::class);
        $tenant = $this->getTenant($request);

        $query = Penghargaan::query();
        if (!$tenant && Auth::user()->hasRole('super-admin')) {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $penghargaans = $query->latest()->paginate(10);

        return view('admin.profil_CRUD.penghargaan_CRUD.index', [
            'tenant' => $tenant,
            'penghargaans' => $penghargaans,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Penghargaan::class);
        $tenant = $this->getTenant($request);
        return view('admin.profil_CRUD.penghargaan_CRUD.create', [
            'tenant' => $tenant,
            'penghargaan' => new Penghargaan(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Penghargaan::class);
        $tenant = $this->getTenant($request);

        $validated = $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'tingkat' => 'required|string|max:100',
            'instansi_pemberi' => 'required|string|max:255',
        ]);

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validated['perangkat_daerah_id'] = $tenant->id;
        }

        Penghargaan::create($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Penghargaan baru berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $penghargaanId = $request->route('penghargaan');

        $query = Penghargaan::where('id', $penghargaanId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $penghargaan = $query->firstOrFail();

        $this->authorize('update', $penghargaan);
        return view('admin.profil_CRUD.penghargaan_CRUD.edit', compact('tenant', 'penghargaan'));
    }

    public function update(Request $request)
    {
        $tenant = $this->getTenant($request);
        $penghargaanId = $request->route('penghargaan');

        $query = Penghargaan::where('id', $penghargaanId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $penghargaan = $query->firstOrFail();

        $this->authorize('update', $penghargaan);
        $validated = $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'tingkat' => 'required|string|max:100',
            'instansi_pemberi' => 'required|string|max:255',
        ]);
        $penghargaan->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Penghargaan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $penghargaanId = $request->route('penghargaan');

        $query = Penghargaan::where('id', $penghargaanId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $penghargaan = $query->firstOrFail();

        $this->authorize('delete', $penghargaan);
        $penghargaan->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Penghargaan berhasil dihapus.');
    }
}
