@csrf
@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Oops!</strong> <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
    <ul class="mt-2 list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
<div class="space-y-4">
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul <span class="text-red-500">*</span></label>
        <input type="text" name="judul" id="judul" value="{{ old('judul', $peranProgram->judul ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
    </div>
    
    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi <span class="text-red-500">*</span></label>
        <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $peranProgram->deskripsi ?? '') }}">
        <trix-editor input="deskripsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></trix-editor>
    </div>
    
    <div>
        <label for="urutan" class="block text-sm font-medium text-gray-700">Nomor Urut Tampilan <span class="text-red-500">*</span></label>
        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $peranProgram->urutan ?? '0') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        <p class="text-xs text-gray-500 mt-1">Angka lebih kecil tampil lebih dulu.</p>
    </div>
</div>
<div class="flex justify-end mt-8">
    <a href="{{ route($routePrefix . '.index', $routeParameters) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition-colors">Batal</a>
    <button type="submit" class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan Data</button>
</div>