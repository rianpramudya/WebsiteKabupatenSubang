<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Sejarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SejarahController extends Controller
{

    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.profil.sejarah.' . $action;
        }
        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            return 'admin.kecamatan.profil.sejarah.' . $action;
        }
        return 'admin.kabupaten.profil.sejarah.' . $action;
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
        $query = Sejarah::query();

        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }

        $this->authorize('viewAny', [Sejarah::class, $tenant]);
        $sejarahs = $query->orderBy('urutan')->paginate(10);

        return view('admin.profil_CRUD.sejarah_CRUD.index', compact('tenant', 'sejarahs'));
    }

    public function create(Request $request): View
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('create', [Sejarah::class, $tenant]);
        return view('admin.profil_CRUD.sejarah_CRUD.create', ['tenant' => $tenant, 'sejarah' => new Sejarah()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        $authTenant = $tenant ?? Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        $this->authorize('create', [Sejarah::class, $authTenant]);

        $validated = $request->validate([
            'tahun' => 'required|string|max:50',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'required|integer',
        ]);

        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            $validated['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validated['perangkat_daerah_id'] = $tenant->id;
        }

        Sejarah::create($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data timeline sejarah baru berhasil ditambahkan.');
    }

    public function edit(Request $request): View
    {
        $tenant = $this->getTenant($request);
        $sejarahId = $request->route('sejarah');
        $query = Sejarah::where('id', $sejarahId);

        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $sejarah = $query->firstOrFail();

        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $sejarah);
        return view('admin.profil_CRUD.sejarah_CRUD.edit', compact('tenant', 'sejarah'));
    }

    public function update(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        $sejarahId = $request->route('sejarah');
        $query = Sejarah::where('id', $sejarahId);

        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $sejarah = $query->firstOrFail();

        $this->authorize('update', $sejarah);
        $validated = $request->validate([
            'tahun' => 'required|string|max:50',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'required|integer',
        ]);
        $sejarah->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data timeline sejarah berhasil diperbarui.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        $sejarahId = $request->route('sejarah');
        $query = Sejarah::where('id', $sejarahId);

        if ($tenant instanceof Kecamatan && $tenant->slug !== 'kabupaten-subang') {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $sejarah = $query->firstOrFail();

        $this->authorize('delete', $sejarah);
        $sejarah->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data timeline sejarah berhasil dihapus.');
    }

    public function editProfil(Request $request): View
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);
        return view('admin.profil_CRUD.sejarah_CRUD.edit_profil', compact('tenant'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);

        $request->validate([
            'sejarah' => 'required|string',
            'arti_lambang' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=1/1',
            'sejarah_img_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=16/9',
            'sejarah_img_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=16/9',
            'sejarah_img_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=16/9',
        ], [
            'logo.dimensions' => 'Rasio gambar Logo harus 1:1 (persegi).',
            'sejarah_img_1.dimensions' => 'Rasio Gambar Sejarah 1 harus 16:9 (lanskap).',
            'sejarah_img_2.dimensions' => 'Rasio Gambar Sejarah 2 harus 16:9 (lanskap).',
            'sejarah_img_3.dimensions' => 'Rasio Gambar Sejarah 3 harus 16:9 (lanskap).',
        ]);

        $tenantData = $request->only(['sejarah', 'arti_lambang']);
        if ($request->hasFile('logo')) {
            if ($tenant->logo)
                Storage::disk('public')->delete($tenant->logo);
            $tenantData['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $image_fields = ['sejarah_img_1', 'sejarah_img_2', 'sejarah_img_3'];
        foreach ($image_fields as $field) {
            if ($request->hasFile($field)) {
                if ($tenant->{$field})
                    Storage::disk('public')->delete($tenant->{$field});
                $tenantData[$field] = $request->file($field)->store('sejarah_images', 'public');
            }
        }
        $tenant->update($tenantData);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Sejarah, Lambang, dan Gambar Utama berhasil diperbarui.');
    }

    public function destroyImage(Request $request): RedirectResponse
    {
        $tenant = $this->getTenant($request);
        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }
        $this->authorize('update', $tenant);

        $validated = $request->validate([
            'image_field' => 'required|string|in:sejarah_img_1,sejarah_img_2,sejarah_img_3,logo',
        ]);

        $imageField = $validated['image_field'];

        if ($tenant->{$imageField}) {
            Storage::disk('public')->delete($tenant->{$imageField});
            $tenant->update([$imageField => null]);
            $message = "Gambar berhasil dihapus.";
        } else {
            $message = "Gambar tidak ditemukan.";
        }

        return redirect()
            ->route($this->getRouteName($tenant, 'editProfil'), $this->getRouteParameters($tenant))
            ->with('success', $message);
    }
}