@php
    if ($tenant) {
        $isKecamatan = $tenant instanceof \App\Models\Kecamatan;
        $baseRouteName = $isKecamatan ? 'admin.kecamatan.' : 'admin.perangkat-daerah.';
        $routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
        $tenantName = $tenant->name;
    } else {
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = []; // Rute kabupaten tidak butuh parameter
        $tenantName = 'Kabupaten';
    }
@endphp

@csrf

<div class="space-y-6">
    <div>
        <label for="nama_penghargaan" class="block text-sm font-medium text-gray-700 mb-1">Nama Penghargaan <span class="text-red-500">*</span></label>
        <input type="text" name="nama_penghargaan" id="nama_penghargaan" value="{{ old('nama_penghargaan', $penghargaan->nama_penghargaan ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
            <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $penghargaan->tahun ?? date('Y')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required placeholder="Contoh: 2025">
        </div>
        <div>
            <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1">Tingkat <span class="text-red-500">*</span></label>
            <input type="text" name="tingkat" id="tingkat" value="{{ old('tingkat', $penghargaan->tingkat ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required placeholder="Contoh: Nasional, Provinsi">
        </div>
    </div>

    <div>
        <label for="instansi_pemberi" class="block text-sm font-medium text-gray-700 mb-1">Instansi Pemberi <span class="text-red-500">*</span></label>
        <input type="text" name="instansi_pemberi" id="instansi_pemberi" value="{{ old('instansi_pemberi', $penghargaan->instansi_pemberi ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">
    <a href="{{ route($baseRouteName . 'profil.penghargaan.index', $routeParameters) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">Batal</a>
    <button type="submit" class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan</button>
</div>
