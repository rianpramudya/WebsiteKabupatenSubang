@csrf
@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Oops!</strong> <span class="block sm:inline">Ada beberapa masalah dengan input
        Anda.</span>
    <ul class="mt-2 list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="nama_desa" class="block text-sm font-medium text-gray-700">Nama Desa/Kelurahan <span
                class="text-red-500">*</span></label>
        <input type="text" name="nama_desa" id="nama_desa"
            value="{{ old('nama_desa', $wilayahAdministrasi->nama_desa ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required>
    </div>
    <div>
        <label for="kepala_desa" class="block text-sm font-medium text-gray-700">Kepala Desa/Lurah</label>
        <input type="text" name="kepala_desa" id="kepala_desa"
            value="{{ old('kepala_desa', $wilayahAdministrasi->kepala_desa ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>
    <div>
        <label for="jumlah_penduduk" class="block text-sm font-medium text-gray-700">Jumlah Penduduk</label>
        <input type="number" name="jumlah_penduduk" id="jumlah_penduduk"
            value="{{ old('jumlah_penduduk', $wilayahAdministrasi->jumlah_penduduk ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            placeholder="Contoh: 5400">
    </div>
    <div>
        <label for="luas_wilayah" class="block text-sm font-medium text-gray-700">Luas Wilayah</label>
        <input type="text" name="luas_wilayah" id="luas_wilayah"
            value="{{ old('luas_wilayah', $wilayahAdministrasi->luas_wilayah ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            placeholder="Contoh: 270.5 Ha">
    </div>
</div>
<div class="flex justify-end mt-8">

    <a href="{{ route($crudRoutePrefix . '.index', $routeParameters) }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition-colors">Batal</a>
    <button type="submit"
        class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan
        Data</button>
</div>