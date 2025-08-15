<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgendaRequest;
use App\Models\Agenda;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        return $request->route('kecamatan') ?? $request->route('perangkatDaerah');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.agenda.' . $action;
        }
        if ($tenant instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.agenda.' . $action;
        }
        return 'admin.kabupaten.agenda.' . $action;
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

    public function index(Request $request)
    {
        $this->authorize('viewAny', Agenda::class);
        $tenant = $this->getTenant($request);

        $query = Agenda::query();

       
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }

        $agendas = $query->latest()->paginate(15);

        return view('admin.agenda_CRUD.index', compact('tenant', 'agendas'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Agenda::class);
        $tenant = $this->getTenant($request);
        
        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.agenda_CRUD.create', compact('tenant', 'kecamatans', 'perangkatDaerahs'));
    }

    public function store(AgendaRequest $request)
    {
        $this->authorize('create', Agenda::class);
        $tenant = $this->getTenant($request);
        $data = $request->validated();
        $user = Auth::user();

        $redirectTenant = $tenant;

        if ($user->hasRole('super-admin')) {
            if ($request->owner_type == 'pd' && $request->filled('perangkat_daerah_id')) {
                $data['perangkat_daerah_id'] = $request->perangkat_daerah_id;
                $data['kecamatan_id'] = null;
                $redirectTenant = PerangkatDaerah::find($data['perangkat_daerah_id']);
            } elseif ($request->owner_type == 'kecamatan' && $request->filled('kecamatan_id')) {
                $data['kecamatan_id'] = $request->kecamatan_id;
                $data['perangkat_daerah_id'] = null;
                $redirectTenant = Kecamatan::find($data['kecamatan_id']);
            } else { // Termasuk 'kabupaten'
                $data['kecamatan_id'] = null;
                $data['perangkat_daerah_id'] = null;
                $redirectTenant = null;
            }
        } else { // Untuk admin kecamatan atau PD
            if ($tenant instanceof Kecamatan) {
                $data['kecamatan_id'] = $tenant->id;
            } elseif ($tenant instanceof PerangkatDaerah) {
                $data['perangkat_daerah_id'] = $tenant->id;
            }
        }

        Agenda::create($data);

        return redirect()->route($this->getRouteName($redirectTenant, 'index'), $this->getRouteParameters($redirectTenant))
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $agendaId = $request->route('agenda');

        $query = Agenda::where('id', $agendaId);
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            // Pastikan hanya agenda level kabupaten yang bisa diakses tanpa tenant
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $agenda = $query->firstOrFail();

        $this->authorize('update', $agenda);

        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.agenda_CRUD.edit', compact('tenant', 'agenda', 'kecamatans', 'perangkatDaerahs'));
    }

    public function update(AgendaRequest $request)
    {
        $tenant = $this->getTenant($request);
        $agendaId = $request->route('agenda');

        $query = Agenda::where('id', $agendaId);
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $agenda = $query->firstOrFail();

        $this->authorize('update', $agenda);
        $data = $request->validated();
        $user = Auth::user();

        $redirectTenant = $tenant;

        if ($user->hasRole('super-admin')) {
            if ($request->owner_type == 'pd' && $request->filled('perangkat_daerah_id')) {
                $data['perangkat_daerah_id'] = $request->perangkat_daerah_id;
                $data['kecamatan_id'] = null;
                $redirectTenant = PerangkatDaerah::find($data['perangkat_daerah_id']);
            } elseif ($request->owner_type == 'kecamatan' && $request->filled('kecamatan_id')) {
                $data['kecamatan_id'] = $request->kecamatan_id;
                $data['perangkat_daerah_id'] = null;
                $redirectTenant = Kecamatan::find($data['kecamatan_id']);
            } else {
                $data['kecamatan_id'] = null;
                $data['perangkat_daerah_id'] = null;
                $redirectTenant = null;
            }
        }

        $agenda->update($data);

        return redirect()->route($this->getRouteName($redirectTenant, 'index'), $this->getRouteParameters($redirectTenant))
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $agendaId = $request->route('agenda');

        $query = Agenda::where('id', $agendaId);
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $agenda = $query->firstOrFail();

        $this->authorize('delete', $agenda);
        $agenda->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Agenda berhasil dihapus.');
    }
}
