<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use App\Models\{Kecamatan, Budaya, PerangkatDaerah};
use App\Http\Requests\Admin\Wisata\{StoreBudayaRequest, UpdateBudayaRequest};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BudayaController extends Controller
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
            return 'admin.perangkat-daerah.wisata.budaya.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.wisata.budaya.' . $action;
        }
        return 'admin.kabupaten.wisata.budaya.' . $action;
    }

    public function index(Request $request)
    {
        $tenant = $this->getTenant($request);
        $query = Budaya::query();

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $budayas = $query->orderBy('nama')->get();

        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.budaya_CRUD.index', compact('kecamatan', 'tenant', 'budayas'));
    }

    public function create(Request $request)
    {
        $tenant = $this->getTenant($request);
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.budaya_CRUD.create', compact('kecamatan', 'tenant'));
    }

    public function store(StoreBudayaRequest $request)
    {
        $tenant = $this->getTenant($request);
        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('wisata/budaya', 'public');
        }
        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        $validated['published_at'] = now();

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        }

        Budaya::create($validated);
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Seni & Budaya berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $budayaId = $request->route('budaya');

        $query = Budaya::where('id', $budayaId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $budaya = $query->firstOrFail();
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;

        return view('admin.wisata_CRUD.budaya_CRUD.edit', compact('kecamatan', 'tenant', 'budaya'));
    }

    public function update(UpdateBudayaRequest $request)
    {
        $tenant = $this->getTenant($request);
        $budayaId = $request->route('budaya');

        $query = Budaya::where('id', $budayaId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $budaya = $query->firstOrFail();

        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            if ($budaya->gambar) Storage::disk('public')->delete($budaya->gambar);
            $validated['gambar'] = $request->file('gambar')->store('wisata/budaya', 'public');
        }
        if ($request->nama !== $budaya->nama) {
            $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        }
        $budaya->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Seni & Budaya berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $budayaId = $request->route('budaya');

        $query = Budaya::where('id', $budayaId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $budaya = $query->firstOrFail();

        if ($budaya->gambar) Storage::disk('public')->delete($budaya->gambar);
        $budaya->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Seni & Budaya berhasil dihapus.');
    }
}
