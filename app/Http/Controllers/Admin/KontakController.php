<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class KontakController extends Controller
{
    private function getTenant(Request $request): ?Model
    {
        if ($perangkatDaerah = $request->route('perangkatDaerah')) {
            return $perangkatDaerah;
        }
        return $request->route('kecamatan');
    }

    private function getRouteName(?Model $tenant, string $action): string
    {
        if ($tenant instanceof Kecamatan) {
            return $tenant->slug === 'kabupaten-subang'
                ? "admin.kabupaten.kontak.{$action}"
                : "admin.kecamatan.kontak.{$action}";
        }
        if ($tenant instanceof PerangkatDaerah) {
            return "admin.perangkat-daerah.kontak.{$action}";
        }
        return "admin.kabupaten.kontak.{$action}";
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

    public function edit(Request $request)
    {
        $tenant = $this->getTenant($request);

        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }

        $this->authorize('update', $tenant);
        return view('admin.kontak_CRUD.edit', ['tenant' => $tenant]);
    }

    public function update(Request $request)
    {
        $tenant = $this->getTenant($request);

        if (!$tenant) {
            $tenant = Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
        }

        $this->authorize('update', $tenant);
        $validated = $request->validate([
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'alamat'         => 'nullable|string',
            'link_facebook'  => 'nullable|url|max:255',
            'link_twitter'   => 'nullable|url|max:255',
            'link_youtube'   => 'nullable|url|max:255',
            'link_instagram' => 'nullable|url|max:255',
        ]);
        $tenant->update($validated);

        return redirect()->route($this->getRouteName($tenant, 'edit'), $this->getRouteParameters($tenant))
            ->with('success', 'Informasi kontak dan sosial media berhasil diperbarui.');
    }
}
