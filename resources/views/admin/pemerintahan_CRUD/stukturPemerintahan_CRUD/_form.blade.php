@csrf
@if ($errors->any())
{{-- Kode error handling tetap sama --}}
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Kode input fields tetap sama --}}
    <div class="md:col-span-2 space-y-4">
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pejabat <span class="text-red-500">*</span></label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $pejabat->nama ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>
        <div>
            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan <span class="text-red-500">*</span></label>
            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pejabat->jabatan ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>
        <div>
            <label for="urutan" class="block text-sm font-medium text-gray-700">Nomor Urut Tampilan <span class="text-red-500">*</span></label>
            <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $pejabat->urutan ?? '0') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            <p class="text-xs text-gray-500 mt-1">Angka lebih kecil tampil lebih dulu.</p>
        </div>
    </div>
    <div class="md:col-span-1">
        <label for="foto" class="block text-sm font-medium text-gray-700">Foto Pejabat</label>
        <div class="mt-1 flex flex-col items-center">
            <img id="foto-preview" src="{{ isset($pejabat) && $pejabat->foto ? asset('storage/' . $pejabat->foto) : 'https://placehold.co/300x300/e2e8f0/64748b?text=Preview' }}" alt="Foto preview" class="h-48 w-48 rounded-full object-cover mb-4">
            <input type="file" name="foto" id="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" onchange="previewImage(event)">
            <p class="text-xs text-gray-500 mt-2">Opsional. Max: 2MB.</p>
        </div>
    </div>
</div>
<div class="flex justify-end mt-8">
    {{-- [FIXED] Tombol Batal sekarang dinamis --}}
    <a href="{{ route($routePrefix . '.index', $routeParameters) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition-colors">Batal</a>
    <button type="submit" class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan Data</button>
</div>
@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('foto-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush