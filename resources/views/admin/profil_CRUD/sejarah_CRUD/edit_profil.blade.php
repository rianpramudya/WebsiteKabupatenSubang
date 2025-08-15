@extends('layouts.app')

@php
    // [PERBAIKAN] Logika ini sekarang menangani 3 konteks: Kecamatan, Perangkat Daerah, dan Kabupaten
    if ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
        // Ini untuk Kecamatan biasa
        $baseRouteName = 'admin.kecamatan.';
        $routeParameters = ['kecamatan' => $tenant->slug];
    } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
        // Ini untuk Perangkat Daerah
        $baseRouteName = 'admin.perangkat-daerah.';
        $routeParameters = ['perangkatDaerah' => $tenant->slug];
    } else {
        // Ini untuk level Kabupaten
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = []; // Rute kabupaten tidak butuh parameter
    }
@endphp

@section('title', 'Edit Sejarah & Lambang - ' . $tenant->name)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Sejarah Awal & Lambang</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">
        {{-- [FIX] Form action sekarang dinamis --}}
        <form action="{{ route($baseRouteName . 'profil.sejarah.updateProfil', $routeParameters) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Field untuk Sejarah Awal --}}
            <div class="mb-6">
                <label for="sejarah" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Sejarah Awal</label>
                {{-- [FIX] Menggunakan variabel $tenant --}}
                <textarea name="sejarah" id="sejarah" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('sejarah', $tenant->sejarah) }}</textarea>
            </div>

            {{-- Field untuk Arti Lambang --}}
            <div class="mb-6">
                <label for="arti_lambang" class="block text-gray-700 text-sm font-bold mb-2">Arti Lambang</label>
                {{-- [FIX] Menggunakan variabel $tenant --}}
                <textarea name="arti_lambang" id="arti_lambang" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('arti_lambang', $tenant->arti_lambang) }}</textarea>
            </div>

            {{-- Field untuk Upload Logo --}}
            <div class="mb-6">
                <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Ganti Lambang/Logo</label>
                <input type="file" name="logo" id="logo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @if($tenant->logo)
                    <div class="mt-2">
                        <p class="text-xs text-gray-600">Lambang Saat Ini:</p>
                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo" class="w-24 h-24 mt-1 border p-1 object-contain">
                    </div>
                @endif
            </div>

            <hr class="my-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Gambar-gambar Sejarah</h3>
            <p class="text-sm text-gray-600 mb-6">Kosongkan jika tidak ingin mengubah gambar.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="mb-4">
                    <label for="sejarah_img_1" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sejarah 1</label>
                    <input type="file" name="sejarah_img_1" id="sejarah_img_1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @if($tenant->sejarah_img_1)
                        <div class="mt-2">
                            <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $tenant->sejarah_img_1) }}" class="mt-1 w-full h-32 object-cover rounded">
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="sejarah_img_2" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sejarah 2</label>
                    <input type="file" name="sejarah_img_2" id="sejarah_img_2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @if($tenant->sejarah_img_2)
                         <div class="mt-2">
                            <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $tenant->sejarah_img_2) }}" class="mt-1 w-full h-32 object-cover rounded">
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="sejarah_img_3" class="block text-gray-700 text-sm font-bold mb-2">Gambar Sejarah 3</label>
                    <input type="file" name="sejarah_img_3" id="sejarah_img_3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @if($tenant->sejarah_img_3)
                         <div class="mt-2">
                            <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $tenant->sejarah_img_3) }}" class="mt-1 w-full h-32 object-cover rounded">
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">
                {{-- [FIX] Link Batal sekarang dinamis --}}
                <a href="{{ route($baseRouteName . 'profil.sejarah.index', $routeParameters) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">Batal</a>
                <button type="submit" class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>
@endsection
