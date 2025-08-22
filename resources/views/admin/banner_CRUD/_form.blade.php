@php
    // Persiapan variabel untuk rute batal yang dinamis
    $homeRoute = $tenant instanceof \App\Models\Kecamatan
        ? route('kecamatan.show', $tenant->slug)
        : route('perangkat.show', $tenant->slug);
@endphp

{{-- 1. PRATINJAU BANNER SAAT INI --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Pratinjau Banner Saat Ini</label>
    <div class="w-full p-4 border-2 border-dashed border-gray-300 rounded-lg text-center bg-gray-50 min-h-[250px] flex items-center justify-center">
        @if($tenant->banner_url)
            @if(Str::startsWith($tenant->banner_url, ['http://', 'https://']))
                @php
                    preg_match('/(?:v=|v\/|embed\/|youtu\.be\/|\/v\/|\/e\/|watch\?v=|\&v=)([^#\&\?]*).*/', $tenant->banner_url, $matches);
                    $videoId = $matches[1] ?? null;
                @endphp
                @if($videoId)
                    <div class="aspect-video w-full"><iframe class="w-full h-full rounded-md shadow-lg"
                            src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe></div>
                @else
                    <p class="text-red-500">URL YouTube tidak valid.</p>
                @endif
            @elseif(Storage::disk('public')->exists($tenant->banner_url))
                @php $mimeType = Storage::disk('public')->mimeType($tenant->banner_url); @endphp
                @if(Str::startsWith($mimeType, 'video'))
                    <video src="{{ Storage::url($tenant->banner_url) }}" controls
                        class="max-w-full h-auto mx-auto rounded-md shadow-lg"></video>
                @elseif(Str::startsWith($mimeType, 'image'))
                    <img src="{{ Storage::url($tenant->banner_url) }}" class="max-w-full h-auto mx-auto rounded-md shadow-lg">
                @endif
            @else
                <p class="text-red-500 font-semibold">File banner ({{ $tenant->banner_url }}) tidak ditemukan di server.</p>
            @endif
        @else
            <div class="text-gray-400">
                <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 4v.01M28 8L16 20m12-12v8m0 4v.01M28 8H12a4 4 0 00-4 4v20m32-12v8m0 4v.01"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="mt-2 text-sm">Banner belum diatur.</p>
            </div>
        @endif
    </div>
</div>

{{-- 2. PILIHAN TIPE BANNER --}}
<div>
    <label class="block text-sm font-medium text-gray-700">Pilih Tipe Banner Baru</label>
    <div class="mt-2 flex rounded-md shadow-sm">
        <button type="button" @click="bannerType = 'upload'"
            :class="{'bg-[#1E4E7C] text-white': bannerType === 'upload', 'bg-white hover:bg-gray-50 text-gray-700': bannerType !== 'upload'}"
            class="px-4 py-2 border border-gray-300 rounded-l-md text-sm font-medium w-full transition-colors duration-150">Upload
            File (Gambar/Video)</button>
        <button type="button" @click="bannerType = 'youtube'"
            :class="{'bg-[#1E4E7C] text-white': bannerType === 'youtube', 'bg-white hover:bg-gray-50 text-gray-700': bannerType !== 'youtube'}"
            class="px-4 py-2 border-t border-b border-r border-gray-300 rounded-r-md text-sm font-medium w-full transition-colors duration-150">Link
            YouTube</button>
    </div>
    <input type="hidden" name="banner_type" x-model="bannerType">
</div>

{{-- 3. AREA UPLOAD FILE --}}
<div x-show="bannerType === 'upload'" x-transition style="display: none;">
    <label for="banner_file" class="block text-sm font-medium text-gray-700">Upload Banner Baru</label>
    <div @dragover.prevent @drop.prevent="handleDrop"
        class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
        :class="{'border-[#1E4E7C] bg-blue-50': isDragging}" @dragenter="isDragging = true"
        @dragleave="isDragging = false">
        <div class="space-y-1 text-center">
            <div class="mb-4 min-h-[48px] flex items-center justify-center">
                <template x-if="newImagePreview"><img :src="newImagePreview"
                        class="mx-auto max-h-48 rounded-md shadow-md"></template>
                <template x-if="newVideoPreview"><video :src="newVideoPreview" controls
                        class="mx-auto max-h-48 rounded-md shadow-md"></video></template>
                <svg x-show="!newImagePreview && !newVideoPreview" class="mx-auto h-12 w-12 text-gray-400"
                    stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 4v.01M28 8L16 20m12-12v8m0 4v.01M28 8H12a4 4 0 00-4 4v20m32-12v8m0 4v.01"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="flex text-sm text-gray-600 justify-center">
                <label for="banner_file"
                    class="relative cursor-pointer bg-white rounded-md font-medium text-[#1E4E7C] hover:text-blue-800">
                    <span>Pilih file untuk diupload</span>
                    <input id="banner_file" name="banner_file" type="file" class="sr-only" @change="handleFileSelect">
                </label>
                <p class="pl-1">atau seret dan lepas</p>
            </div>
            <p class="text-xs text-gray-500">
                **Rekomendasi rasio 3:1** (Contoh: 1920x640px). Maks 100MB.
            </p>
            <p x-show="validationError" x-text="validationError" class="text-sm font-semibold text-red-600 mt-2" style="display: none;"></p>
        </div>
    </div>
</div>

{{-- 4. AREA INPUT YOUTUBE --}}
<div x-show="bannerType === 'youtube'" x-transition style="display: none;">
    <label for="banner_url" class="block text-sm font-medium text-gray-700">URL Video YouTube</label>
    <div class="mt-2">
        <input type="text" name="banner_url" id="banner_url"
            value="{{ old('banner_url', Str::startsWith($tenant->banner_url, 'http') ? $tenant->banner_url : '') }}"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#1E4E7C] focus:ring-[#1E4E7C] sm:text-sm"
            placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
    </div>
</div>

{{-- 5. TOMBOL AKSI --}}
<div class="mt-8 pt-6 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-between items-center gap-4">
    @if($tenant->banner_url)
        <button @click.prevent="showDeleteModal = true" type="button"
            class="w-full sm:w-auto px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                </path>
            </svg>
            Hapus Banner
        </button>
    @else
        <div></div>
    @endif
    <div class="flex justify-end space-x-3 w-full sm:w-auto">
        <a href="{{ $homeRoute }}"
            class="w-full sm:w-auto bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E4E7C] transition-colors flex items-center justify-center">Batal</a>
        
        <button type="submit"
            :disabled="bannerType === 'upload' && validationError.length > 0"
            :class="{ 'opacity-50 cursor-not-allowed': bannerType === 'upload' && validationError.length > 0 }"
            class="w-full sm:w-auto bg-[#1E4E7C] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E4E7C] transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                </path>
            </svg>
            Simpan Perubahan
        </button>
    </div>
</div>