<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInfografisRequest;
use App\Models\Infografis;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfografisController extends Controller
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
            return 'admin.perangkat-daerah.profil.infografis.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.profil.infografis.' . $action;
        }
        return 'admin.kabupaten.infografis.' . $action;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Infografis::class);
        $tenant = $this->getTenant($request);

        $query = Infografis::query();
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $infografis = $query->latest()->paginate(10);

        return view('admin.infografis_CRUD.index', compact('tenant', 'infografis'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Infografis::class);
        $tenant = $this->getTenant($request);
        return view('admin.infografis_CRUD.create', compact('tenant'));
    }

    public function store(StoreInfografisRequest $request)
    {
        $this->authorize('create', Infografis::class);
        $tenant = $this->getTenant($request);
        $validatedData = $request->validated();

        $validatedData['slug'] = Str::slug($validatedData['judul']) . '-' . uniqid();

        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('infografis', 'public');
        }

        if ($tenant instanceof Kecamatan) {
            $validatedData['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validatedData['perangkat_daerah_id'] = $tenant->id;
        }

        Infografis::create($validatedData);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $infografiId = $request->route('infografi');

        $query = Infografis::withoutGlobalScopes()->where('id', $infografiId);

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $infografi = $query->firstOrFail();

        $this->authorize('update', $infografi);
        return view('admin.infografis_CRUD.edit', compact('tenant', 'infografi'));
    }

    public function update(StoreInfografisRequest $request)
    {
        $tenant = $this->getTenant($request);
        $infografiId = $request->route('infografi');

        $query = Infografis::withoutGlobalScopes()->where('id', $infografiId);

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $infografi = $query->firstOrFail();

        $this->authorize('update', $infografi);
        $validatedData = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($infografi->gambar) {
                Storage::disk('public')->delete($infografi->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('infografis', 'public');
        }

        if ($request->has('hapus_gambar') && !$request->hasFile('gambar')) {
            if ($infografi->gambar) {
                Storage::disk('public')->delete($infografi->gambar);
                $validatedData['gambar'] = null;
            }
        }

        $infografi->update($validatedData);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $infografiId = $request->route('infografi');

        $query = Infografis::withoutGlobalScopes()->where('id', $infografiId);

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $infografi = $query->firstOrFail();

        $this->authorize('delete', $infografi);

        if ($infografi->gambar) {
            Storage::disk('public')->delete($infografi->gambar);
        }
        $infografi->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Infografis berhasil dihapus.');
    }
}
