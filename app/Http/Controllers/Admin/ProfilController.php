<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;

class ProfilController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.profil.' . $action;
        }
        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            return 'admin.kecamatan.profil.' . $action;
        }
        return 'admin.kabupaten.profil.' . $action;
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

    public function index(Request $request): View
    {
        $tenant = $this->getTenant($request);
        if ($tenant) {
            $this->authorize('update', $tenant);
        }
        return view('admin.profil_CRUD.index', compact('tenant'));
    }

    public function editVisiMisi(Request $request): View
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);
        return view('admin.profil_CRUD.visimisi_CRUD.edit', compact('tenant'));
    }

    public function updateVisiMisi(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);
        $validated = $request->validate(['visi' => 'nullable|string', 'misi' => 'nullable|string']);
        $tenant->update($validated);
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    public function editWilayah(Request $request): View
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);
        return view('admin.profil_CRUD.wilayah_CRUD.edit', compact('tenant'));
    }

    public function updateWilayah(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);

        $validated = $request->validate([
            'peta_url'        => 'nullable|url',
            'letak_geografis' => 'nullable|string',
            'iklim'           => 'nullable|string',
            'demografi'       => 'nullable|string',
            'topografi'       => 'nullable|string',
        ]);

        $tenant->update($validated);
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Informasi Wilayah berhasil diperbarui.');
    }
}