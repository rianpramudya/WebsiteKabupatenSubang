@push('styles')

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>

        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;

        }

        .trix-content {
            min-height: 200px;

            border-color: #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .trix-content:focus {
            border-color: #4f46e5;

            box-shadow: 0 0 0 1px #4f46e5;
        }
    </style>
@endpush

@push('scripts')

    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
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

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Objek Wisata <span
                class="text-red-500">*</span></label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $objekWisata->nama ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required>
    </div>
    <div>
        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori <span
                class="text-red-500">*</span></label>
        <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $objekWisata->kategori ?? 'Alam') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required placeholder="Contoh: Alam, Buatan, Sejarah">
    </div>
    <div>
        <label for="lokasi_teks" class="block text-sm font-medium text-gray-700">Lokasi Teks <span
                class="text-red-500">*</span></label>
        <input type="text" name="lokasi_teks" id="lokasi_teks"
            value="{{ old('lokasi_teks', $objekWisata->lokasi_teks ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required placeholder="Contoh: Desa Cijambe, Kecamatan Cijambe">
    </div>

    <div class="md:col-span-2">
        <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700">Deskripsi Singkat <span
                class="text-red-500">*</span></label>
        <input id="deskripsi_singkat" type="hidden" name="deskripsi_singkat"
            value="{{ old('deskripsi_singkat', $objekWisata->deskripsi_singkat ?? '') }}">
        <trix-editor input="deskripsi_singkat" class="mt-1 trix-content"></trix-editor>
    </div>

    <div class="md:col-span-2">
        <label for="google_maps_url" class="block text-sm font-medium text-gray-700">URL Google Maps</label>
        <input type="url" name="google_maps_url" id="google_maps_url"
            value="{{ old('google_maps_url', $objekWisata->google_maps_url ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            placeholder="https://maps.app.goo.gl/xxxx">
    </div>

    <div x-data="{
            previewUrl: '{{ isset($objekWisata) && $objekWisata->gambar ? asset('storage/' . $objekWisata->gambar) : '' }}',
            fileName: '{{ isset($objekWisata) && $objekWisata->gambar ? basename($objekWisata->gambar) : '' }}',
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
        <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Banner</label>

        <p class="text-xs text-gray-500 mt-1">Rekomendasi ukuran: rasio 16:9 (contoh: 1280x720 pixels).</p>
        <div x-show="!previewUrl" style="display: none;" class="mt-1">
            <input type="file" id="gambar" name="gambar" @change="handleFileChange" x-ref="gambarInput"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
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

        @if(isset($objekWisata) && $objekWisata->gambar)
            <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1" x-ref="hapusGambarCheckbox"
                class="hidden">
        @endif
    </div>

    <div class="flex items-center pt-6">
        <input type="checkbox" name="is_unggulan" id="is_unggulan" value="1" @checked(old('is_unggulan', $objekWisata->is_unggulan ?? false)) class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="is_unggulan" class="ml-2 block text-sm text-gray-900">Jadikan Wisata Unggulan?</label>
    </div>
</div>
<div class="flex justify-end mt-8">
    <a href="{{ route($crudRoutePrefix . '.index', $routeParameters) }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition-colors">Batal</a>
    <button type="submit"
        class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan
        Data</button>
</div>