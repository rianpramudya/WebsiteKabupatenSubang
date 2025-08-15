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
    // Helper untuk mendapatkan tenant (Kecamatan atau PerangkatDaerah)
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    // Helper untuk mendapatkan parameter rute yang benar
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

    // Helper untuk mendapatkan nama rute yang benar
    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.profil.infografis.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.profil.infografis.' . $action; // <--- PERBAIKAN DI SINI
        }
        return 'admin.kabupaten.infografis.' . $action;
    }

    /**
     * Menampilkan daftar infografis.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Infografis::class);
        $tenant = $this->getTenant($request);

        $query = Infografis::query();
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            // Untuk level kabupaten (superadmin)
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $infografis = $query->latest()->paginate(10);

        return view('admin.infografis_CRUD.index', compact('tenant', 'infografis'));
    }

    /**
     * Menampilkan form untuk membuat infografis baru.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Infografis::class);
        $tenant = $this->getTenant($request);
        return view('admin.infografis_CRUD.create', compact('tenant'));
    }

    /**
     * Menyimpan infografis baru ke database.
     */
    public function store(StoreInfografisRequest $request)
    {
        $this->authorize('create', Infografis::class);
        $tenant = $this->getTenant($request);
        $validatedData = $request->validated();

        // ================================================
        //      TAMBAHKAN BARIS INI UNTUK MEMBUAT SLUG
        // ================================================
        $validatedData['slug'] = Str::slug($validatedData['judul']) . '-' . uniqid();
        // ================================================

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

    /**
     * Menampilkan form untuk mengedit infografis.
     */
    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $infografiId = $request->route('infografi');

        // Mulai query dasar
        $query = Infografis::withoutGlobalScopes()->where('id', $infografiId);

        // [PERBAIKAN] Tambahkan kondisi untuk setiap jenis tenant
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            // Kondisi untuk level Kabupaten (saat $tenant adalah null)
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        // Eksekusi query
        $infografi = $query->firstOrFail();

        $this->authorize('update', $infografi);
        return view('admin.infografis_CRUD.edit', compact('tenant', 'infografi'));
    }

    /**
     * Memperbarui infografis di database.
     */
    public function update(StoreInfografisRequest $request)
    {
        $tenant = $this->getTenant($request);
        $infografiId = $request->route('infografi');

        // Mulai query dasar
        $query = Infografis::withoutGlobalScopes()->where('id', $infografiId);

        // [PERBAIKAN] Tambahkan kondisi untuk setiap jenis tenant
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            // Kondisi untuk level Kabupaten (saat $tenant adalah null)
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        // Eksekusi query
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

    /**
     * Menghapus infografis dari database.
     */
    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $infografiId = $request->route('infografi');

        // Mulai query dasar
        $query = Infografis::withoutGlobalScopes()->where('id', $infografiId);

        // [PERBAIKAN] Tambahkan kondisi untuk setiap jenis tenant
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            // Kondisi untuk level Kabupaten (saat $tenant adalah null)
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        // Eksekusi query
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
