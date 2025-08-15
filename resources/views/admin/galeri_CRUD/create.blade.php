@extends('layouts.app')
@section('title', 'Tambah Media Baru')

@push('styles')
<style>
    /* CSS untuk area drag & drop */
    .file-drop-zone {
        border: 2px dashed #cbd5e1;
        transition: all 0.3s ease-in-out;
    }

    .file-drop-zone.is-dragover {
        border-color: #1E4E7C;
        background-color: rgba(30, 78, 124, 0.05);
    }

    /* CSS untuk preview gambar diubah menjadi thumbnail kecil */
    .preview-thumbnail {
        width: 64px;
        /* 4rem */
        height: 64px;
        /* 4rem */
        object-fit: cover;
        border-radius: 0.5rem;
        /* rounded-lg */
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }
</style>
@endpush

@section('content')
<div id="page-content" class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">Tambah Media ke Galeri</h1>
                <p class="mt-2 text-gray-500">Pilih tipe media dan unggah file atau masukkan link.</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @php
            // ======================================================================
            // PERBAIKAN 1: Membuat action form menjadi dinamis
            // ======================================================================
            $formAction = '#';
            if (isset($kecamatan)) {
            $formAction = route('admin.kecamatan.galeri.store', $kecamatan);
            } elseif (isset($perangkatDaerah)) {
            $formAction = route('admin.perangkat-daerah.galeri.store', $perangkatDaerah);
            }
            @endphp
            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data"
                class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg" x-data="{ 
                      mediaType: '{{ old('tipe', 'foto') }}',
                      imagePreview: null,
                      isDragover: false,
                      draggedFileName: null,
                      selectedFileName: null
                  }">
                @csrf
                <div class="space-y-8">
                    {{-- LANGKAH 1: Informasi Dasar --}}
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#1E4E7C] text-white rounded-full flex items-center justify-center font-bold text-sm">
                                1</div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-700">Informasi Dasar</h2>
                        </div>

                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Media <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                        </div>

                        <div>
                            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe Media</label>
                            <select name="tipe" id="tipe" x-model="mediaType" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                                <option value="foto">Foto</option>
                                <option value="video_upload">Video (Upload File)</option>
                                <option value="video_yt">Video (Link YouTube)</option>
                            </select>
                        </div>
                    </div>

                    {{-- LANGKAH 2: Upload File atau Link --}}
                    <div>
                        <div class="flex items-center mb-6">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#1E4E7C] text-white rounded-full flex items-center justify-center font-bold text-sm">
                                2</div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-700"
                                x-text="mediaType === 'video_yt' ? 'Masukkan Link' : 'Upload File'"></h2>
                        </div>

                        {{-- Input Foto --}}
                        <div x-show="mediaType === 'foto'" class="space-y-4">
                            <label x-show="!imagePreview" for="file_foto"
                                class="file-drop-zone p-6 text-center rounded-lg cursor-pointer hover:border-[#1E4E7C] flex flex-col items-center justify-center h-48"
                                :class="{ 'is-dragover': isDragover }"
                                @dragover.prevent="isDragover = true; if($event.dataTransfer.files.length > 0) { draggedFileName = $event.dataTransfer.files[0].name }"
                                @dragleave.prevent="isDragover = false; draggedFileName = null"
                                @drop.prevent="isDragover = false; draggedFileName = null; $refs.fotoInput.files = $event.dataTransfer.files; imagePreview = URL.createObjectURL($event.dataTransfer.files[0]); selectedFileName = $event.dataTransfer.files[0].name;">

                                <div x-show="isDragover && draggedFileName" class="text-center">
                                    <i class="fas fa-file-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 font-semibold">Lepas untuk mengunggah:</p>
                                    <p class="text-xs text-gray-500" x-text="draggedFileName"></p>
                                </div>

                                <div x-show="!isDragover" class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600">Seret & lepas file foto di sini, atau klik untuk
                                        memilih</p>
                                </div>

                                <input type="file" name="file_foto" id="file_foto" x-ref="fotoInput"
                                    @change="imagePreview = URL.createObjectURL($event.target.files[0]); selectedFileName = $event.target.files[0].name"
                                    class="opacity-0 w-0 h-0">
                            </label>

                            <div x-show="imagePreview"
                                class="border border-gray-200 rounded-lg p-4 flex items-center justify-between space-x-4">
                                <div class="flex items-center space-x-4 overflow-hidden">
                                    <img :src="imagePreview" alt="Image Preview"
                                        class="preview-thumbnail flex-shrink-0">
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-medium text-gray-800 truncate" x-text="selectedFileName">
                                        </p>
                                        <p class="text-xs text-gray-500">Gambar berhasil dipilih.</p>
                                    </div>
                                </div>
                                <button type="button"
                                    @click="imagePreview = null; selectedFileName = null; $refs.fotoInput.value = ''"
                                    class="text-sm font-semibold text-red-600 hover:text-red-800">Hapus</button>
                            </div>
                        </div>

                        {{-- Input Video Direct --}}
                        <div x-show="mediaType === 'video_upload'">
                            <label for="file_video_upload" class="block text-sm font-medium text-gray-700">Pilih File
                                Video (Upload)</label>
                            <input type="file" name="file_video_upload" id="file_video_upload"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file: 100MB.</p>
                        </div>

                        {{-- Input Video via URL --}}
                        <div x-show="mediaType === 'video_yt'">
                            <label for="file_video_yt" class="block text-sm font-medium text-gray-700">URL Video
                                YouTube</label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fab fa-youtube text-red-500"></i>
                                </div>
                                <input type="url" name="file_video_yt" id="file_video_yt"
                                    value="{{ old('file_video_yt') }}"
                                    placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx"
                                    class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('super-admin'))
                    <hr>
                    <div
                        x-data="{ ownerType: '{{ old('owner_type', (isset($perangkatDaerah) ? 'pd' : 'kecamatan')) }}' }">
                        <div class="flex items-center mb-4">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#1E4E7C] text-white rounded-full flex items-center justify-center font-bold text-sm">
                                3</div>
                            <h2 class="ml-4 text-lg font-semibold text-gray-700">Pemilik Konten</h2>
                        </div>
                        <div class="flex space-x-4 mb-4">
                            <label class="flex items-center">
                                <input type="radio" x-model="ownerType" name="owner_type" value="kecamatan"
                                    class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300">
                                <span class="ml-2 text-sm text-gray-600">Kecamatan</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" x-model="ownerType" name="owner_type" value="pd"
                                    class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300">
                                <span class="ml-2 text-sm text-gray-600">Perangkat Daerah</span>
                            </label>
                        </div>

                        <div x-show="ownerType === 'kecamatan'">
                            <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Pilih Kecamatan
                                <span class="text-red-500">*</span></label>
                            <select id="kecamatan_id" name="kecamatan_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $itemKecamatan)
                                <option value="{{ $itemKecamatan->id }}" {{ old('kecamatan_id', $kecamatan->id ?? null)
                                    == $itemKecamatan->id ? 'selected' : '' }}>
                                    {{ $itemKecamatan->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div x-show="ownerType === 'pd'">
                            <label for="perangkat_daerah_id" class="block text-sm font-medium text-gray-700">Pilih
                                Perangkat Daerah <span class="text-red-500">*</span></label>
                            <select id="perangkat_daerah_id" name="perangkat_daerah_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                                <option value="">-- Pilih Perangkat Daerah --</option>
                                @foreach($perangkatDaerahs as $pd)
                                <option value="{{ $pd->id }}" {{ old('perangkat_daerah_id', $perangkatDaerah->id ??
                                    null) == $pd->id ? 'selected' : '' }}>
                                    {{ $pd->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                </div>
                <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                    @php
                    // ======================================================================
                    // PERBAIKAN 2: Membuat tautan "Batal" menjadi dinamis
                    // ======================================================================
                    $backRoute = '#';
                    if (isset($kecamatan)) {
                    $backRoute = route('admin.kecamatan.galeri.index', $kecamatan);
                    } elseif (isset($perangkatDaerah)) {
                    $backRoute = route('admin.perangkat-daerah.galeri.index', $perangkatDaerah);
                    }
                    @endphp
                    <a href="{{ $backRoute }}"
                        class="bg-gray-100 text-gray-700 font-bold py-2 px-6 rounded-lg hover:bg-gray-200 transition-colors">Batal</a>
                    <button type="submit"
                        class="bg-[#1E4E7C] text-white font-bold py-2 px-6 rounded-lg hover:brightness-110 transition-colors">Simpan
                        Media</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- [DITAMBAHKAN] Blok CSS dan JavaScript untuk animasi --}}
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(10px);
        }
    }

    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }

    body.fading-out #page-content {
        animation: fadeOut 0.5s ease-out forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fadeOutDuration = 500; 
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(form a)');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                if (link.closest('form[onsubmit]')) {
                    return;
                }
                event.preventDefault(); 
                document.body.classList.add('fading-out');
                setTimeout(() => {
                    window.location.href = link.href;
                }, fadeOutDuration);
            });
        });

        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                document.body.classList.remove('fading-out');
            }
        });
    });
</script>
@endsection