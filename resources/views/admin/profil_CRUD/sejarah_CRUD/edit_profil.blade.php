@extends('layouts.app')

@php
    // Logika routing multi-tenant
    if ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
        $baseRouteName = 'admin.kecamatan.';
        $routeParameters = ['kecamatan' => $tenant->slug];
    } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
        $baseRouteName = 'admin.perangkat-daerah.';
        $routeParameters = ['perangkatDaerah' => $tenant->slug];
    } else {
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = [];
    }
@endphp

@section('title', 'Edit Sejarah & Lambang - ' . $tenant->name)

{{-- ================================================================= --}}
{{-- Menambahkan Aset Trix (CSS) dan Custom Style --}}
{{-- ================================================================= --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        .trix-content {
            min-height: 150px;
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

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Sejarah Awal & Lambang</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">

        {{-- ==== FORM UTAMA ==== --}}
        <form action="{{ route($baseRouteName . 'profil.sejarah.updateProfil', $routeParameters) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Field untuk Sejarah Awal --}}
            <div class="mb-6">
                <label for="sejarah" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Sejarah Awal</label>
                <input id="sejarah" type="hidden" name="sejarah" value="{{ old('sejarah', $tenant->sejarah) }}">
                <trix-editor input="sejarah" class="trix-content"></trix-editor>
            </div>

            {{-- Field untuk Arti Lambang --}}
            <div class="mb-6">
                <label for="arti_lambang" class="block text-gray-700 text-sm font-bold mb-2">Arti Lambang</label>
                <input id="arti_lambang" type="hidden" name="arti_lambang" value="{{ old('arti_lambang', $tenant->arti_lambang) }}">
                <trix-editor input="arti_lambang" class="trix-content"></trix-editor>
            </div>

            {{-- Upload Logo + tombol hapus --}}
            <div class="mb-6">
                <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Ganti Lambang/Logo</label>
                <input type="file" name="logo" id="logo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                @if($tenant->logo)
                    <div class="mt-2">
                        <p class="text-xs text-gray-600">Lambang Saat Ini:</p>
                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo" class="w-24 h-24 mt-1 border p-1 object-contain">
                        <button type="submit" form="delete-logo-form" class="text-xs text-red-600 hover:text-red-800 font-semibold mt-2" onclick="return confirm('Anda yakin ingin menghapus logo ini?');">
                            Hapus Logo
                        </button>
                    </div>
                @endif
            </div>

            <hr class="my-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Gambar-gambar Sejarah</h3>
            <p class="text-sm text-gray-600 mb-6">Kosongkan jika tidak ingin mengubah gambar.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Gambar 1 --}}
                <div class="mb-4">
                    <label for="sejarah_img_1" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sejarah 1</label>
                    <input type="file" name="sejarah_img_1" id="sejarah_img_1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @if($tenant->sejarah_img_1)
                        <div class="mt-2">
                            <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $tenant->sejarah_img_1) }}" class="mt-1 w-full h-32 object-cover rounded">
                            <button type="submit" form="delete-sejarah_img_1-form" class="w-full text-center text-sm font-semibold text-red-600 hover:text-red-800 mt-2" onclick="return confirm('Anda yakin ingin menghapus gambar ini?');">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus Gambar
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Gambar 2 --}}
                <div class="mb-4">
                    <label for="sejarah_img_2" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sejarah 2</label>
                    <input type="file" name="sejarah_img_2" id="sejarah_img_2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @if($tenant->sejarah_img_2)
                        <div class="mt-2">
                            <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $tenant->sejarah_img_2) }}" class="mt-1 w-full h-32 object-cover rounded">
                            <button type="submit" form="delete-sejarah_img_2-form" class="w-full text-center text-sm font-semibold text-red-600 hover:text-red-800 mt-2" onclick="return confirm('Anda yakin ingin menghapus gambar ini?');">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus Gambar
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Gambar 3 --}}
                <div class="mb-4">
                    <label for="sejarah_img_3" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sejarah 3</label>
                    <input type="file" name="sejarah_img_3" id="sejarah_img_3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @if($tenant->sejarah_img_3)
                        <div class="mt-2">
                            <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $tenant->sejarah_img_3) }}" class="mt-1 w-full h-32 object-cover rounded">
                            <button type="submit" form="delete-sejarah_img_3-form" class="w-full text-center text-sm font-semibold text-red-600 hover:text-red-800 mt-2" onclick="return confirm('Anda yakin ingin menghapus gambar ini?');">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus Gambar
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">
                <a href="{{ route($baseRouteName . 'profil.sejarah.index', $routeParameters) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan Perubahan</button>
            </div>
        </form>
        {{-- ==== /FORM UTAMA ==== --}}

        {{-- ==== FORM-FORM HAPUS (DI LUAR FORM UTAMA) ==== --}}
        @if($tenant->logo)
            <form id="delete-logo-form" action="{{ route($baseRouteName . 'profil.sejarah.destroyImage', $routeParameters) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_field" value="logo">
            </form>
        @endif
        @if($tenant->sejarah_img_1)
            <form id="delete-sejarah_img_1-form" action="{{ route($baseRouteName . 'profil.sejarah.destroyImage', $routeParameters) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_field" value="sejarah_img_1">
            </form>
        @endif
        @if($tenant->sejarah_img_2)
            <form id="delete-sejarah_img_2-form" action="{{ route($baseRouteName . 'profil.sejarah.destroyImage', $routeParameters) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_field" value="sejarah_img_2">
            </form>
        @endif
        @if($tenant->sejarah_img_3)
            <form id="delete-sejarah_img_3-form" action="{{ route($baseRouteName . 'profil.sejarah.destroyImage', $routeParameters) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="image_field" value="sejarah_img_3">
            </form>
        @endif
        {{-- ==== /FORM-FORM HAPUS ==== --}}
    </div>
</div>
@endsection

{{-- ================================================================= --}}
{{-- Menambahkan Aset Trix (JS) --}}
{{-- ================================================================= --}}
@push('scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush
