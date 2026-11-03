<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanKeuanganRequest;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuanganController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteParameters(?Model $tenant, array $additionalParams = []): array
    {
        if ($tenant instanceof Kecamatan) {
            return array_merge(['kecamatan' => $tenant->slug], $additionalParams);
        }
        if ($tenant instanceof PerangkatDaerah) {
            return array_merge(['perangkatDaerah' => $tenant->slug], $additionalParams);
        }
        return $additionalParams;
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.laporan-keuangan.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.laporan-keuangan.' . $action;
        }
        return 'admin.kabupaten.laporan-keuangan.' . $action;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', LaporanKeuangan::class);
        $tenant = $this->getTenant($request);

        $query = LaporanKeuangan::query();
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $laporanKeuangans = $query->latest()->paginate(15);

        return view('admin.laporanKeuangan_CRUD.index', compact('tenant', 'laporanKeuangans'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', LaporanKeuangan::class);
        $tenant = $this->getTenant($request);
        return view('admin.laporanKeuangan_CRUD.create', compact('tenant'));
    }

    public function store(StoreLaporanKeuanganRequest $request)
    {
        $this->authorize('create', LaporanKeuangan::class);
        $tenant = $this->getTenant($request);
        $validatedData = $request->validated();

        if ($request->hasFile('file_laporan')) {
            $validatedData['file_url'] = $request->file('file_laporan')->store('laporan_keuangan', 'public');
        }

        if ($tenant instanceof Kecamatan) {
            $validatedData['kecamatan_id'] = $tenant->id;
        } elseif ($tenant instanceof PerangkatDaerah) {
            $validatedData['perangkat_daerah_id'] = $tenant->id;
        }

        LaporanKeuangan::create($validatedData);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Laporan keuangan berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $laporanKeuanganId = $request->route('laporan_keuangan');

        $query = LaporanKeuangan::withoutGlobalScopes()->where('id', $laporanKeuanganId);

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $laporanKeuangan = $query->firstOrFail();

        $this->authorize('update', $laporanKeuangan);
        return view('admin.laporanKeuangan_CRUD.edit', compact('tenant', 'laporanKeuangan'));
    }

    public function update(StoreLaporanKeuanganRequest $request)
    {
        $tenant = $this->getTenant($request);
        $laporanKeuanganId = $request->route('laporan_keuangan');

        $query = LaporanKeuangan::withoutGlobalScopes()->where('id', $laporanKeuanganId);

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $laporanKeuangan = $query->firstOrFail();

        $this->authorize('update', $laporanKeuangan);
        $validatedData = $request->validated();

        if ($request->hasFile('file_laporan')) {
            if ($laporanKeuangan->file_url) {
                Storage::disk('public')->delete($laporanKeuangan->file_url);
            }
            $validatedData['file_url'] = $request->file('file_laporan')->store('laporan_keuangan', 'public');
        }

        $laporanKeuangan->update($validatedData);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $laporanKeuanganId = $request->route('laporan_keuangan');

        $query = LaporanKeuangan::withoutGlobalScopes()->where('id', $laporanKeuanganId);

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $laporanKeuangan = $query->firstOrFail();

        $this->authorize('delete', $laporanKeuangan);
        if ($laporanKeuangan->file_url) {
            Storage::disk('public')->delete($laporanKeuangan->file_url);
        }
        $laporanKeuangan->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
