<?php

namespace App\Http\Controllers\Admin\Pemerintahan;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\WilayahAdministrasi;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class WilayahAdministrasiController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteParameters(?Model $tenant, array $additionalParams = []): array
    {
        if ($tenant instanceof Kecamatan) {
            $tenantParam = ['kecamatan' => $tenant->slug];
        } elseif ($tenant instanceof PerangkatDaerah) {
            $tenantParam = ['perangkatDaerah' => $tenant->slug];
        } else {
            $tenantParam = [];
        }
        return array_merge($tenantParam, $additionalParams);
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.pemerintahan.wilayah-administrasi.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.pemerintahan.wilayah-administrasi.' . $action;
        }
        return 'admin.kabupaten.pemerintahan.wilayah-administrasi.' . $action;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', WilayahAdministrasi::class);
        $tenant = $this->getTenant($request);

        $query = WilayahAdministrasi::query();
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $wilayahAdministrasis = $query->orderBy('nama_desa')->get();
        return view('admin.pemerintahan_CRUD.wilayahAdministrasi_CRUD.index', compact('tenant', 'wilayahAdministrasis'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', WilayahAdministrasi::class);
        $tenant = $this->getTenant($request);
        return view('admin.pemerintahan_CRUD.wilayahAdministrasi_CRUD.create', compact('tenant'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', WilayahAdministrasi::class);
        $tenant = $this->getTenant($request);

        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kepala_desa' => 'nullable|string|max:255',
            'luas_wilayah' => 'nullable|string|max:100',
            'jumlah_penduduk' => 'nullable|integer',
        ]);

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validated['perangkat_daerah_id'] = $tenant->id;
        }

        WilayahAdministrasi::create($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data wilayah administrasi berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $wilayahAdministrasiId = $request->route('wilayah_administrasi');

        $query = WilayahAdministrasi::withoutGlobalScopes()->where('id', $wilayahAdministrasiId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $wilayahAdministrasi = $query->firstOrFail();

        $this->authorize('update', $wilayahAdministrasi);
        return view('admin.pemerintahan_CRUD.wilayahAdministrasi_CRUD.edit', compact('tenant', 'wilayahAdministrasi'));
    }

    public function update(Request $request)
    {
        $tenant = $this->getTenant($request);
        $wilayahAdministrasiId = $request->route('wilayah_administrasi');

        $query = WilayahAdministrasi::withoutGlobalScopes()->where('id', $wilayahAdministrasiId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $wilayahAdministrasi = $query->firstOrFail();

        $this->authorize('update', $wilayahAdministrasi);
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kepala_desa' => 'nullable|string|max:255',
            'luas_wilayah' => 'nullable|string|max:100',
            'jumlah_penduduk' => 'nullable|integer',
        ]);

        $wilayahAdministrasi->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data wilayah administrasi berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $wilayahAdministrasiId = $request->route('wilayah_administrasi');

        $query = WilayahAdministrasi::withoutGlobalScopes()->where('id', $wilayahAdministrasiId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $wilayahAdministrasi = $query->firstOrFail();

        $this->authorize('delete', $wilayahAdministrasi);
        $wilayahAdministrasi->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data wilayah administrasi berhasil dihapus.');
    }
}
