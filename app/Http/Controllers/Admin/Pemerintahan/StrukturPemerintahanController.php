<?php

namespace App\Http\Controllers\Admin\Pemerintahan;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StrukturPemerintahanController extends Controller
{

    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteParameters(?Model $tenant, array $additionalParams = []): array
    {
        $tenantParam = [];
        if ($tenant instanceof Kecamatan) {
            $tenantParam = ['kecamatan' => $tenant->slug];
        } elseif ($tenant instanceof PerangkatDaerah) {
            $tenantParam = ['perangkatDaerah' => $tenant->slug];
        }
        return array_merge($tenantParam, $additionalParams);
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.pemerintahan.pejabats.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.pemerintahan.pejabats.' . $action;
        }

        return 'admin.kabupaten.pemerintahan.pejabats.' . $action;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Pejabat::class);
        $tenant = $this->getTenant($request);

        $query = Pejabat::query();
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $pejabats = $query->orderBy('urutan')->get();

        return view('admin.pemerintahan_CRUD.stukturPemerintahan_CRUD.index', compact('tenant', 'pejabats'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Pejabat::class);
        $tenant = $this->getTenant($request);
        $pejabat = new Pejabat();
        return view('admin.pemerintahan_CRUD.stukturPemerintahan_CRUD.create', compact('tenant', 'pejabat'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Pejabat::class);
        $tenant = $this->getTenant($request);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=1/1',
            'urutan' => 'required|integer|min:0',
        ], [
            'foto.dimensions' => 'Ukuran foto tidak valid. Harap gunakan foto dengan rasio 1:1 (persegi).'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pejabat', 'public');
        }

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validated['perangkat_daerah_id'] = $tenant->id;
        }

        Pejabat::create($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Struktur Pemerintahan berhasil ditambahkan.');
    }

    public function show(Request $request)
    {
        $tenant = $this->getTenant($request);
        $pejabat = $request->route('pejabat');

        return redirect()->route(
            $this->getRouteName($tenant, 'edit'),
            $this->getRouteParameters($tenant, ['pejabat' => $pejabat])
        );
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $pejabatId = $request->route('pejabat');

        $query = Pejabat::withoutGlobalScopes()->where('id', $pejabatId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $pejabat = $query->firstOrFail();

        $this->authorize('update', $pejabat);
        return view('admin.pemerintahan_CRUD.stukturPemerintahan_CRUD.edit', compact('tenant', 'pejabat'));
    }

    public function update(Request $request)
    {
        $tenant = $this->getTenant($request);
        $pejabatId = $request->route('pejabat');

        $query = Pejabat::withoutGlobalScopes()->where('id', $pejabatId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $pejabat = $query->firstOrFail();

        $this->authorize('update', $pejabat);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            if ($pejabat->foto) Storage::disk('public')->delete($pejabat->foto);
            $validated['foto'] = $request->file('foto')->store('pejabat', 'public');
        }

        $pejabat->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Struktur Pemerintahan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $pejabatId = $request->route('pejabat');

        $query = Pejabat::withoutGlobalScopes()->where('id', $pejabatId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $pejabat = $query->firstOrFail();

        $this->authorize('delete', $pejabat);
        if ($pejabat->foto) {
            Storage::disk('public')->delete($pejabat->foto);
        }
        $pejabat->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Struktur Pemerintahan berhasil dihapus.');
    }
}
