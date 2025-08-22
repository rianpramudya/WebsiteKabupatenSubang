@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }

    .trix-content {
        min-height: 250px;
        border-color: #d1d5db;
        border-radius: 0.375rem;
        padding: 0.75rem;
        background-color: white;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .trix-content:focus {
        border-color: #1E4E7C;
        box-shadow: 0 0 0 1px #1E4E7C;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
{{-- Memastikan AlpineJS dimuat untuk fungsionalitas interaktif --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endpush

@csrf
@if ($errors->any())
<div class="bg-[#E20E0D]/10 border-l-4 border-[#E20E0D] text-[#c41a19] p-4 mb-6" role="alert">
    <p class="font-bold">Terjadi Kesalahan</p>
    <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Kolom Utama (Form) --}}
    <div class="md:col-span-2 bg-white p-8 rounded-lg shadow-md space-y-6">
        <div class="mb-6">
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita <span
                    class="text-[#E20E0D]">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-[#1E4E7C] focus:ring-[#1E4E7C]"
                required>
        </div>
        <div>
            <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">Isi Berita <span
                    class="text-[#E20E0D]">*</span></label>
            <input id="isi" type="hidden" name="isi" value="{{ old('isi', $berita->isi ?? '') }}">
            <trix-editor input="isi" class="trix-content"></trix-editor>
        </div>
    </div>

    {{-- Kolom Samping (Pengaturan) --}}
    <div class="md:col-span-1 space-y-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-[#1E4E7C]">Pengaturan</h3>

            <div class="mb-6">
                <label for="kategori_berita_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span
                        class="text-[#E20E0D]">*</span></label>
                <select id="kategori_berita_id" name="kategori_berita_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-[#1E4E7C] focus:ring-[#1E4E7C]"
                    required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('kategori_berita_id', $berita->kategori_berita_id ?? null) == $kategori->id)>
                        {{ $kategori->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                <input type="text" id="tags" name="tags"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-[#1E4E7C] focus:ring-[#1E4E7C]"
                    placeholder="Contoh: pariwisata, kuliner"
                    value="{{ old('tags', $berita->tags->pluck('name')->implode(', ') ?? '') }}">
                <small class="mt-1 text-xs text-gray-500">Pisahkan setiap tag dengan koma (,).</small>
            </div>

            @if(auth()->user()->hasRole('super-admin'))
            @php
            $ownerType = 'kabupaten';
            if (old('owner_type')) {
                $ownerType = old('owner_type');
            } elseif (!empty($berita) && $berita->perangkat_daerah_id) {
                $ownerType = 'pd';
            } elseif (!empty($berita) && $berita->kecamatan_id) {
                $ownerType = 'kecamatan';
            }
            @endphp
            <div x-data="{ ownerType: '{{ $ownerType }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pemilik Konten</label>
                <div class="flex space-x-4 mb-4">
                    <label class="flex items-center"><input type="radio" x-model="ownerType" name="owner_type"
                            value="kabupaten" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span
                            class="ml-2 text-sm text-gray-600">Kabupaten</span></label>
                    <label class="flex items-center"><input type="radio" x-model="ownerType" name="owner_type"
                            value="kecamatan" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span
                            class="ml-2 text-sm text-gray-600">Kecamatan</span></label>
                    <label class="flex items-center"><input type="radio" x-model="ownerType" name="owner_type"
                            value="pd" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span
                            class="ml-2 text-sm text-gray-600">Perangkat Daerah</span></label>
                </div>
                <div x-show="ownerType === 'kecamatan'" class="mb-6">
                    <select id="kecamatan_id" name="kecamatan_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-[#1E4E7C] focus:ring-[#1E4E7C]">
                        <option value="">Pilih Kecamatan</option>
                        @foreach($kecamatans as $itemKecamatan)
                        <option value="{{ $itemKecamatan->id }}" @selected(old('kecamatan_id', $berita->kecamatan_id ?? null) == $itemKecamatan->id)>{{ $itemKecamatan->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div x-show="ownerType === 'pd'" class="mb-6">
                    <select id="perangkat_daerah_id" name="perangkat_daerah_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-[#1E4E7C] focus:ring-[#1E4E7C]">
                        <option value="">Pilih Perangkat Daerah</option>
                        @foreach($perangkatDaerahs as $pd)
                        <option value="{{ $pd->id }}" @selected(old('perangkat_daerah_id', $berita->perangkat_daerah_id ?? null) == $pd->id)>{{ $pd->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <div x-data="imageUploader('{{ $berita->gambar ? asset('storage/' . $berita->gambar) : '' }}', '{{ $berita->gambar ? basename($berita->gambar) : '' }}')">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                
                <div x-show="!previewUrl" style="display: none;">
                    <input type="file" id="gambar" name="gambar" @change="handleFileChange" x-ref="gambarInput"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#1E4E7C]/10 file:text-[#1E4E7C] hover:file:bg-[#1E4E7C]/20">
                </div>

                <p x-show="validationError" x-text="validationError" class="text-xs font-semibold text-red-600 mt-2" style="display: none;"></p>
                <p class="text-xs text-gray-500 mt-1">Wajib rasio 16:9 (Contoh: 1280x720px).</p>

                <div x-show="previewUrl" class="mt-2 border border-gray-200 rounded-lg p-2" style="display: none;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center min-w-0">
                            <img :src="previewUrl" alt="Preview Gambar"
                                class="h-14 w-14 object-cover rounded-md mr-3 flex-shrink-0">
                            <span x-text="fileName" class="text-sm text-gray-600 font-medium truncate"></span>
                        </div>
                        <button type="button" @click="removeImage"
                            class="text-sm font-semibold text-red-600 hover:text-red-800 transition-colors ml-2"
                            title="Hapus gambar">Hapus</button>
                    </div>
                </div>

                @if($berita->gambar)
                <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1" x-ref="hapusGambarCheckbox" class="hidden">
                @endif
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 bg-white p-6 rounded-lg shadow-md">
            <a href="{{ $backRouteUrl }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
            <button type="submit"
                :disabled="validationError.length > 0"
                :class="{ 'opacity-50 cursor-not-allowed': validationError.length > 0 }"
                class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                Simpan
            </button>
        </div>
    </div>
</div>

@push('scripts-footer')
<script>
    function imageUploader(initialPreview, initialFileName) {
        return {
            previewUrl: initialPreview,
            fileName: initialFileName,
            validationError: '',

            handleFileChange(event) {
                const file = event.target.files[0];
                if (!file) {
                    this.validationError = '';
                    return;
                }
                this.validateFile(file, event.target);
            },

            validateFile(file, fileInput) {
                const targetAspectRatio = 16 / 9;
                const tolerance = 0.05;

                if (file.type.startsWith('image/')) {
                    const img = new Image();
                    img.onload = () => {
                        const aspectRatio = img.width / img.height;
                        if (Math.abs(aspectRatio - targetAspectRatio) > tolerance) {
                            this.validationError = `Rasio gambar (${img.width}x${img.height}) tidak 16:9.`;
                            this.previewUrl = initialPreview;
                            this.fileName = initialFileName;
                            fileInput.value = null;
                        } else {
                            this.validationError = ''; 
                            this.previewUrl = URL.createObjectURL(file);
                            this.fileName = file.name;
                            if (this.$refs.hapusGambarCheckbox) { this.$refs.hapusGambarCheckbox.checked = false; }
                        }
                    };
                    img.src = URL.createObjectURL(file);
                } else {
                    this.validationError = 'File yang diunggah harus berupa gambar.';
                    fileInput.value = null;
                }
            },

            removeImage() {
                this.previewUrl = '';
                this.fileName = '';
                this.$refs.gambarInput.value = null;
                this.validationError = '';
                if (this.$refs.hapusGambarCheckbox) {
                    this.$refs.hapusGambarCheckbox.checked = true;
                }
            }
        }
    }
</script>
@endpush