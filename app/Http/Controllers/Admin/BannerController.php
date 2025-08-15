<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    private function getOwner(Request $request): Model
    {
        if ($perangkatDaerah = $request->route('perangkatDaerah')) {
            return $perangkatDaerah;
        }

        if ($kecamatan = $request->route('kecamatan')) {
            return $kecamatan;
        }
        return Kecamatan::where('slug', 'kabupaten-subang')->firstOrFail();
    }

    private function getRedirectRoute(Model $owner): string
    {
        if ($owner instanceof PerangkatDaerah) {
            return 'admin.perangkat-daerah.banner.edit';
        }

        if ($owner->slug === 'kabupaten-subang') {
            return 'admin.kabupaten.banner.edit';
        }

        return 'admin.kecamatan.banner.edit';
    }

    private function getRedirectParameters(Model $owner): array
    {
        if ($owner->slug === 'kabupaten-subang') {
            return []; 
        }

        $key = ($owner instanceof Kecamatan) ? 'kecamatan' : 'perangkatDaerah';
        return [$key => $owner->slug];
    }

    public function edit(Request $request)
    {
        $owner = $this->getOwner($request);
        $this->authorize('update', $owner);

        return view('admin.banner_CRUD.edit', ['tenant' => $owner]);
    }

    public function update(Request $request)
    {
        $owner = $this->getOwner($request);
        $this->authorize('update', $owner);

        $request->validate([
            'banner_type' => 'required|in:upload,youtube',
            'banner_file' => ['required_if:banner_type,upload', 'nullable', 'file', 'mimetypes:image/*,video/*', 'max:102400'],
            'banner_url' => ['required_if:banner_type,youtube', 'nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
        ]);

        try {
            $currentBanner = $owner->banner_url;
            $bannerType = $request->banner_type; 

            $deleteOldFile = function () use ($currentBanner) {
                if ($currentBanner && !Str::startsWith($currentBanner, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($currentBanner);
                }
            };

            if ($bannerType === 'youtube') {
                $deleteOldFile();
               
                $owner->update([
                    'banner_url' => $request->banner_url,
                    'banner_type' => $bannerType
                ]);
                return redirect()->back()->with('success', 'Banner YouTube berhasil diperbarui!');
            }

            if ($bannerType === 'upload' && $request->hasFile('banner_file')) {
                $deleteOldFile();
                $path = $request->file('banner_file')->store('tenant-banners', 'public');
                
                $owner->update([
                    'banner_url' => $path,
                    'banner_type' => $bannerType
                ]);
                return redirect()->back()->with('success', 'File banner berhasil diupload!');
            }

            return redirect()->back()->with('info', 'Tidak ada perubahan yang disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $owner = $this->getOwner($request);
        $this->authorize('update', $owner);

        $currentBanner = $owner->banner_url;

        if ($currentBanner) {
            if (!Str::startsWith($currentBanner, ['http://', 'https://'])) {
                Storage::disk('public')->delete($currentBanner);
            }
            $owner->update(['banner_url' => null]);

            return redirect()->route($this->getRedirectRoute($owner), $this->getRedirectParameters($owner))
                ->with('success', 'Banner berhasil dihapus.');
        }

        return redirect()->route($this->getRedirectRoute($owner), $this->getRedirectParameters($owner))
            ->with('info', 'Tidak ada banner untuk dihapus.');
    }
}
