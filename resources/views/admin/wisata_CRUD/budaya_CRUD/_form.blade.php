@push('styles')
{{-- Menggunakan versi dan styling yang sama dengan halaman Berita --}}
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
{{-- Menggunakan file Javascript UMD yang terbukti berfungsi --}}
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
{{-- Menambahkan script Alpine.js untuk preview gambar --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endpush


@csrf
@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Oops!</strong> <span class="block sm:inline">Ada beberapa masalah dengan input
        Anda.</span>
    <ul class="mt-2 list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<div class="space-y-6">
    <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Seni/Budaya <span
                class="text-red-500">*</span></label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $budaya->nama ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required>
    </div>

    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi <span
                class="text-red-500">*</span></label>
        <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $budaya->deskripsi ?? '') }}">
        <trix-editor input="deskripsi" class="mt-1 trix-content"></trix-editor>
    </div>

    {{-- MODIFIKASI DIMULAI DI SINI: FITUR UPLOAD GAMBAR DENGAN PREVIEW --}}
    <div x-data="{
        previewUrl: '{{ isset($budaya) && $budaya->gambar ? asset('storage/' . $budaya->gambar) : '' }}',
        fileName: '{{ isset($budaya) && $budaya->gambar ? basename($budaya->gambar) : '' }}',
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
            // Jika ada gambar sebelumnya, tandai untuk dihapus di backend
            if (this.$refs.hapusGambarCheckbox) {
                this.$refs.hapusGambarCheckbox.checked = true;
            }
        }
    }">
        <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>

        {{-- Tombol upload file (akan disembunyikan jika ada preview) --}}
        <div x-show="!previewUrl" style="display: none;" class="mt-1">
            <input type="file" id="gambar" name="gambar" @change="handleFileChange" x-ref="gambarInput"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        </div>

        {{-- Container untuk preview (akan ditampilkan jika ada preview) --}}
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

        {{-- Checkbox tersembunyi untuk menandai penghapusan gambar lama --}}
        @if(isset($budaya) && $budaya->gambar)
        <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1" x-ref="hapusGambarCheckbox"
            class="hidden">
        @endif
    </div>
    {{-- MODIFIKASI SELESAI --}}

</div>
<div class="flex justify-end mt-8">
    {{-- [PERBAIKAN] Tautan Batal sekarang menggunakan variabel yang benar --}}
    <a href="{{ route($crudRoutePrefix . '.index', $routeParameters) }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition-colors">Batal</a>
    <button type="submit"
        class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan
        Data</button>
</div>

<hr class="my-6 border-transparent">