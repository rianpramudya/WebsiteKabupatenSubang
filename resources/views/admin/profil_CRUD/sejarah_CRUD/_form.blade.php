@php
    if ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
        $baseRouteName = 'admin.kecamatan.';
        $routeParameters = ['kecamatan' => $tenant->slug];
    } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
        $baseRouteName = 'admin.perangkat-daerah.';
        $routeParameters = ['perangkatDaerah' => $tenant->slug];
    } else {
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = []; // Rute kabupaten tidak butuh parameter
    }
@endphp

@csrf

<div class="space-y-6">
    <div>
        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun / Periode <span class="text-red-500">*</span></label>
        <input type="text" name="tahun" id="tahun" value="{{ old('tahun', $sejarah->tahun ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>
    </div>
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
        <input type="text" name="judul" id="judul" value="{{ old('judul', $sejarah->judul ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>
    </div>
    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
        <textarea name="deskripsi" id="deskripsi" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>{{ old('deskripsi', $sejarah->deskripsi ?? '') }}</textarea>
    </div>
    <div>
        <label for="urutan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Urut <span class="text-red-500">*</span></label>
        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $sejarah->urutan ?? 0) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">

    <a href="{{ route($baseRouteName . 'profil.sejarah.index', $routeParameters) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">Batal</a>
    <button type="submit" class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan</button>
</div>
