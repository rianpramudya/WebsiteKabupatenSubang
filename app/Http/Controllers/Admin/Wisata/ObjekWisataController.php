<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use App\Models\{Kecamatan, ObjekWisata, PerangkatDaerah}; // Tambahkan PerangkatDaerah
use App\Http\Requests\Admin\Wisata\{StoreObjekWisataRequest, UpdateObjekWisataRequest};
use Illuminate\Database\Eloquent\Model; // Tambahkan Model
use Illuminate\Http\Request; // Tambahkan Request
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ObjekWisataController extends Controller
{
    // Helper untuk mendapatkan tenant
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    // Helper untuk mendapatkan parameter rute
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

    // Helper untuk mendapatkan nama rute
    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.wisata.objek-wisata.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.wisata.objek-wisata.' . $action;
        }
        return 'admin.kabupaten.wisata.objek-wisata.' . $action;
    }

    // Method CRUD yang sudah diperbaiki total
    public function index(Request $request)
    {
        $tenant = $this->getTenant($request);
        $query = ObjekWisata::query();

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $objekWisatas = $query->orderBy('nama')->get();

        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.objek_wisata_CRUD.index', compact('kecamatan', 'tenant', 'objekWisatas'));
    }

    public function create(Request $request)
    {
        $tenant = $this->getTenant($request);
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.objek_wisata_CRUD.create', compact('kecamatan', 'tenant'));
    }

    public function store(StoreObjekWisataRequest $request)
    {
        $tenant = $this->getTenant($request);
        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('wisata/objek_wisata', 'public');
        }
        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        }

        ObjekWisata::create($validated);
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Objek Wisata berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $objekWisataId = $request->route('objekWisata');

        $query = ObjekWisata::where('id', $objekWisataId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $objekWisata = $query->firstOrFail();
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;

        return view('admin.wisata_CRUD.objek_wisata_CRUD.edit', compact('kecamatan', 'tenant', 'objekWisata'));
    }

    public function update(UpdateObjekWisataRequest $request)
    {
        $tenant = $this->getTenant($request);
        $objekWisataId = $request->route('objekWisata');

        $query = ObjekWisata::where('id', $objekWisataId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $objekWisata = $query->firstOrFail();

        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            if ($objekWisata->gambar) Storage::disk('public')->delete($objekWisata->gambar);
            $validated['gambar'] = $request->file('gambar')->store('wisata/objek_wisata', 'public');
        }
        if ($request->nama !== $objekWisata->nama) {
            $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        }
        $objekWisata->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Objek Wisata berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $objekWisataId = $request->route('objekWisata');

        $query = ObjekWisata::where('id', $objekWisataId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $objekWisata = $query->firstOrFail();

        if ($objekWisata->gambar) Storage::disk('public')->delete($objekWisata->gambar);
        $objekWisata->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Objek Wisata berhasil dihapus.');
    }
}
