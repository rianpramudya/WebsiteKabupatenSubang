@push('styles')
{{-- Aset yang diperlukan untuk Trix Editor dan styling kustom --}}
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    /* Styling agar Trix Editor menyatu dengan form Anda */
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
        /* Sembunyikan tombol upload file */
    }

    .trix-content {
        min-height: 200px;
        /* Atur tinggi minimal editor */
        border-color: #d1d5db;
        border-radius: 0.375rem;
        background-color: white;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .trix-content:focus {
        border-color: #4f46e5;
        /* Warna focus indigo */
        box-shadow: 0 0 0 1px #4f46e5;
    }
</style>
@endpush

@push('scripts')
{{-- Aset JavaScript yang diperlukan untuk Trix Editor dan AlpineJS --}}
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
@endpush

@csrf
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <p class="font-bold">Terjadi Kesalahan</p>
    <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="space-y-6">
    <div class="mb-4">
        <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Infografis:</label>
        <input type="text" name="judul" id="judul" value="{{ old('judul', $infografi->judul ?? '') }}"
            class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
            required>
    </div>

    <div class="mb-4">
        <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
        <input id="deskripsi" type="hidden" name="deskripsi"
            value="{{ old('deskripsi', $infografi->deskripsi ?? '') }}">
        <trix-editor input="deskripsi" class="trix-content"></trix-editor>
    </div>

    <div class="mb-4">
        <label for="published_at" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Publikasi:</label>
        <input type="datetime-local" name="published_at" id="published_at"
            value="{{ old('published_at', isset($infografi) && $infografi->published_at ? \Carbon\Carbon::parse($infografi->published_at)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
            class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
            required>
    </div>

    <div class="mb-6" x-data="{
        previewUrl: '{{ isset($infografi) && $infografi->gambar ? Storage::url($infografi->gambar) : '' }}',
        fileName: '{{ isset($infografi) && $infografi->gambar ? basename($infografi->gambar) : '' }}',
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.previewUrl = URL.createObjectURL(file);
                this.fileName = file.name;
            }
        },
        removeImage() {
            this.previewUrl = '';
            this.fileName = '';
            this.$refs.gambarInput.value = '';
            if (this.$refs.hapusGambarCheckbox) {
                this.$refs.hapusGambarCheckbox.checked = true;
            }
        }
    }">
        <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Upload Gambar:</label>

        <div x-show="!previewUrl" style="display: none;" class="mt-1">
            <input type="file" id="gambar" name="gambar" @change="handleFileChange" x-ref="gambarInput"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                accept="image/*">
        </div>

        <div x-show="previewUrl" class="mt-2 border border-gray-200 rounded-lg p-2" style="display: none;">
            <div class="flex items-center justify-between">
                <div class="flex items-center min-w-0">
                    <img :src="previewUrl" alt="Preview Gambar"
                        class="h-16 w-16 object-cover rounded-md mr-4 flex-shrink-0">
                    <span x-text="fileName" class="text-sm text-gray-600 font-medium truncate"></span>
                </div>
                <button type="button" @click="removeImage"
                    class="text-sm font-semibold text-red-600 hover:text-red-800 transition-colors ml-4"
                    title="Hapus gambar">
                    Hapus
                </button>
            </div>
        </div>

        @if(isset($infografi) && $infografi->gambar)
        <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1" x-ref="hapusGambarCheckbox"
            class="hidden">
        @endif
    </div>
</div>

<div class="flex items-center justify-end mt-8">
    {{-- [FIXED] Link Batal sekarang dinamis menggunakan variabel yang dikirim dari parent view --}}
    <a href="{{ route($routePrefix . '.index', $routeParameters) }}"
        class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 mr-4">Batal</a>
    <button type="submit"
        class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
        {{ isset($infografi) ? 'Simpan Perubahan' : 'Buat Infografis' }}
    </button>
</div>