<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use App\Models\{Kecamatan, RumahMakan, PerangkatDaerah}; // Tambahkan PerangkatDaerah
use App\Http\Requests\Admin\Wisata\{StoreRumahMakanRequest, UpdateRumahMakanRequest};
use Illuminate\Database\Eloquent\Model; // Tambahkan Model
use Illuminate\Http\Request; // Tambahkan Request
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RumahMakanController extends Controller
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
            return 'admin.perangkat-daerah.wisata.rumah-makan.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.wisata.rumah-makan.' . $action;
        }
        return 'admin.kabupaten.wisata.rumah-makan.' . $action;
    }

    public function index(Request $request)
    {
        $tenant = $this->getTenant($request);
        $query = RumahMakan::query();

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $rumahMakans = $query->orderBy('nama')->get();

        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.rumah_makan_CRUD.index', compact('kecamatan', 'tenant', 'rumahMakans'));
    }

    public function create(Request $request)
    {
        $tenant = $this->getTenant($request);
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.rumah_makan_CRUD.create', compact('kecamatan', 'tenant'));
    }

    public function store(StoreRumahMakanRequest $request)
    {
        $tenant = $this->getTenant($request);
        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('wisata/rumah_makan', 'public');
        }
        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        $validated['published_at'] = now();

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        }

        RumahMakan::create($validated);
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Rumah Makan berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $rumahMakanId = $request->route('rumahMakan');

        $query = RumahMakan::where('id', $rumahMakanId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $rumahMakan = $query->firstOrFail();
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;

        return view('admin.wisata_CRUD.rumah_makan_CRUD.edit', compact('kecamatan', 'tenant', 'rumahMakan'));
    }

    public function update(UpdateRumahMakanRequest $request)
    {
        $tenant = $this->getTenant($request);
        $rumahMakanId = $request->route('rumahMakan');

        $query = RumahMakan::where('id', $rumahMakanId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $rumahMakan = $query->firstOrFail();

        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            if ($rumahMakan->gambar) Storage::disk('public')->delete($rumahMakan->gambar);
            $validated['gambar'] = $request->file('gambar')->store('wisata/rumah_makan', 'public');
        }
        if ($request->nama !== $rumahMakan->nama) {
            $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        }
        $rumahMakan->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Rumah Makan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $rumahMakanId = $request->route('rumahMakan');

        $query = RumahMakan::where('id', $rumahMakanId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $rumahMakan = $query->firstOrFail();

        if ($rumahMakan->gambar) Storage::disk('public')->delete($rumahMakan->gambar);
        $rumahMakan->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Rumah Makan berhasil dihapus.');
    }
}
