<?php

namespace App\Http\Controllers\Admin\Pemerintahan;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\PeranDanProgram;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class PeranProgramController extends Controller
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
            return 'admin.perangkat-daerah.pemerintahan.peran-program.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.pemerintahan.peran-program.' . $action;
        }

        return 'admin.kabupaten.pemerintahan.peran-program.' . $action;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', PeranDanProgram::class);
        $tenant = $this->getTenant($request);

        $query = PeranDanProgram::query();
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $peranDanPrograms = $query->orderBy('urutan')->get();
        return view('admin.pemerintahan_CRUD.peranDanProgram_CRUD.index', compact('tenant', 'peranDanPrograms'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', PeranDanProgram::class);
        $tenant = $this->getTenant($request);
        return view('admin.pemerintahan_CRUD.peranDanProgram_CRUD.create', compact('tenant'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', PeranDanProgram::class);
        $tenant = $this->getTenant($request);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validated['perangkat_daerah_id'] = $tenant->id;
        }

        PeranDanProgram::create($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Peran dan Program berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $peranProgramId = $request->route('peranProgram');

        $query = PeranDanProgram::withoutGlobalScopes()->where('id', $peranProgramId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $peranProgram = $query->firstOrFail();

        $this->authorize('update', $peranProgram);
        return view('admin.pemerintahan_CRUD.peranDanProgram_CRUD.edit', compact('tenant', 'peranProgram'));
    }

    public function update(Request $request)
    {
        $tenant = $this->getTenant($request);
        $peranProgramId = $request->route('peranProgram');

        $query = PeranDanProgram::withoutGlobalScopes()->where('id', $peranProgramId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $peranProgram = $query->firstOrFail();

        $this->authorize('update', $peranProgram);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'required|integer|min:0',
        ]);

        $peranProgram->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Peran dan Program berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $peranProgramId = $request->route('peranProgram');

        $query = PeranDanProgram::withoutGlobalScopes()->where('id', $peranProgramId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $peranProgram = $query->firstOrFail();

        $this->authorize('delete', $peranProgram);
        $peranProgram->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Peran dan Program berhasil dihapus.');
    }
}
