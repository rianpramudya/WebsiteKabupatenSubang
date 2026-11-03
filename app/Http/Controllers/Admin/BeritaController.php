<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Models\Berita;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
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
            return 'admin.perangkat-daerah.berita.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.berita.' . $action;
        }
        return 'admin.kabupaten.berita.' . $action;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Berita::class);
        $tenant = $this->getTenant($request);
        $query = Berita::query();

        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $beritas = $query->with(['kategori', 'tags'])->latest('published_at')->paginate(15);

        return view('admin.berita_CRUD.index', compact('tenant', 'beritas'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Berita::class);
        $tenant = $this->getTenant($request);
        $kategoris = KategoriBerita::orderBy('nama')->get();
        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.berita_CRUD.create', compact('tenant', 'kategoris', 'kecamatans', 'perangkatDaerahs'));
    }

    public function store(StoreBeritaRequest $request)
    {
        $this->authorize('create', Berita::class);
        $tenant = $this->getTenant($request);
        $data = $request->validated();
        $data['slug'] = Str::slug($data['judul']) . '-' . uniqid();
        $data['excerpt'] = Str::limit(strip_tags($request->isi), 150);

        $data['published_at'] = now();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('images/berita', 'public');
        }

        $redirectTenant = $tenant;
        if (Auth::user()->hasRole('super-admin')) {
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
        } else {
            if ($tenant instanceof Kecamatan) {
                $data['kecamatan_id'] = $tenant->id;
            } elseif ($tenant instanceof PerangkatDaerah) {
                $data['perangkat_daerah_id'] = $tenant->id;
            }
        }

        $berita = Berita::create($data);
        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->tags))->map(fn($tag) => strtolower(trim($tag)))->filter()->unique()->all();
            $berita->attachTags($tags);
        }

        return redirect()->route($this->getRouteName($redirectTenant, 'index'), $this->getRouteParameters($redirectTenant))
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Request $request)
    {

        $tenant = $this->getTenant($request);
        $beritaId = $request->route('berita');

        $query = Berita::withoutGlobalScopes()->where('id', $beritaId);
        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {

            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $berita = $query->firstOrFail();

        $this->authorize('view', $berita);

        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        $perangkatDaerah = ($tenant instanceof PerangkatDaerah) ? $tenant : null;

        return view('admin.berita_CRUD.show', compact('berita', 'tenant', 'kecamatan', 'perangkatDaerah'));
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $beritaId = $request->route('berita');
        $query = Berita::withoutGlobalScopes()->where('id', $beritaId);

        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $berita = $query->firstOrFail();

        $this->authorize('update', $berita);
        $kategoris = KategoriBerita::orderBy('nama')->get();
        $kecamatans = Auth::user()->hasRole('super-admin') ? Kecamatan::where('slug', '!=', 'kabupaten-subang')->orderBy('name')->get() : collect();
        $perangkatDaerahs = Auth::user()->hasRole('super-admin') ? PerangkatDaerah::orderBy('name')->get() : collect();

        return view('admin.berita_CRUD.edit', compact('tenant', 'berita', 'kategoris', 'kecamatans', 'perangkatDaerahs'));
    }

    public function update(StoreBeritaRequest $request)
    {
        $tenant = $this->getTenant($request);
        $beritaId = $request->route('berita');
        $query = Berita::withoutGlobalScopes()->where('id', $beritaId);

        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $berita = $query->firstOrFail();

        $this->authorize('update', $berita);
        $data = $request->validated();
        $data['excerpt'] = Str::limit(strip_tags($request->isi), 150);

        if (is_null($berita->published_at)) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('images/berita', 'public');
        }

        $redirectTenant = $tenant;
        if (Auth::user()->hasRole('super-admin')) {
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

        $berita->update($data);
        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->tags))->map(fn($tag) => strtolower(trim($tag)))->filter()->unique()->all();
            $berita->syncTags($tags);
        } else {
            $berita->syncTags([]);
        }

        return redirect()->route($this->getRouteName($redirectTenant, 'index'), $this->getRouteParameters($redirectTenant))
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $beritaId = $request->route('berita');
        $query = Berita::withoutGlobalScopes()->where('id', $beritaId);

        if ($tenant) {
            $query->where($tenant instanceof Kecamatan ? 'kecamatan_id' : 'perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $berita = $query->firstOrFail();

        $this->authorize('delete', $berita);
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->syncTags([]);
        $berita->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Berita berhasil dihapus.');
    }
}
