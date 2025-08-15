<?php

namespace App\Http\Controllers\Admin\Wisata;

use App\Http\Controllers\Controller;
use App\Models\{Kecamatan, Hotel, PerangkatDaerah}; // Tambahkan PerangkatDaerah
use App\Http\Requests\Admin\Wisata\{StoreHotelRequest, UpdateHotelRequest};
use Illuminate\Database\Eloquent\Model; // Tambahkan Model
use Illuminate\Http\Request; // Tambahkan Request
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
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
            return 'admin.perangkat-daerah.wisata.hotel.' . $action;
        }
        if ($tenant instanceof Kecamatan) {
            return 'admin.kecamatan.wisata.hotel.' . $action;
        }
        return 'admin.kabupaten.wisata.hotel.' . $action;
    }

    // Method CRUD yang sudah diperbaiki total
    public function index(Request $request)
    {
        $tenant = $this->getTenant($request);
        $query = Hotel::query();

        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } elseif ($tenant instanceof PerangkatDaerah) {
            $query->where('perangkat_daerah_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id')->whereNull('perangkat_daerah_id');
        }
        $hotels = $query->orderBy('nama')->get();

        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.hotel_CRUD.index', compact('kecamatan', 'tenant', 'hotels'));
    }

    public function create(Request $request)
    {
        $tenant = $this->getTenant($request);
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;
        return view('admin.wisata_CRUD.hotel_CRUD.create', compact('kecamatan', 'tenant'));
    }

    public function store(StoreHotelRequest $request)
    {
        $tenant = $this->getTenant($request);
        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('wisata/hotel', 'public');
        }
        $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        $validated['published_at'] = now();

        if ($tenant instanceof Kecamatan) {
            $validated['kecamatan_id'] = $tenant->id;
        }

        Hotel::create($validated);
        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Hotel berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);
        $hotelId = $request->route('hotel');

        $query = Hotel::where('id', $hotelId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $hotel = $query->firstOrFail();
        $kecamatan = ($tenant instanceof Kecamatan) ? $tenant : null;

        return view('admin.wisata_CRUD.hotel_CRUD.edit', compact('kecamatan', 'tenant', 'hotel'));
    }

    public function update(UpdateHotelRequest $request)
    {
        $tenant = $this->getTenant($request);
        $hotelId = $request->route('hotel');

        $query = Hotel::where('id', $hotelId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $hotel = $query->firstOrFail();

        $validated = $request->validated();
        if ($request->hasFile('gambar')) {
            if ($hotel->gambar) Storage::disk('public')->delete($hotel->gambar);
            $validated['gambar'] = $request->file('gambar')->store('wisata/hotel', 'public');
        }
        if ($request->nama !== $hotel->nama) {
            $validated['slug'] = Str::slug($validated['nama']) . '-' . Str::random(5);
        }
        $hotel->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Hotel berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $tenant = $this->getTenant($request);
        $hotelId = $request->route('hotel');

        $query = Hotel::where('id', $hotelId);
        if ($tenant instanceof Kecamatan) {
            $query->where('kecamatan_id', $tenant->id);
        } else {
            $query->whereNull('kecamatan_id');
        }
        $hotel = $query->firstOrFail();

        if ($hotel->gambar) Storage::disk('public')->delete($hotel->gambar);
        $hotel->delete();

        return redirect()->route($this->getRouteName($tenant, 'index'), $this->getRouteParameters($tenant))
            ->with('success', 'Data Hotel berhasil dihapus.');
    }
}
