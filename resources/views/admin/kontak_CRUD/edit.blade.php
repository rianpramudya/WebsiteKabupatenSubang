@extends('layouts.app')

@php
    // [PERBAIKAN] Logika ini sekarang menangani 3 konteks dengan benar
    if ($tenant instanceof \App\Models\PerangkatDaerah) {
        $updateRoute = route('admin.perangkat-daerah.kontak.update', ['perangkatDaerah' => $tenant]);
    } elseif ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
        $updateRoute = route('admin.kecamatan.kontak.update', ['kecamatan' => $tenant]);
    } else {
        // Ini adalah konteks Kabupaten untuk Superadmin
        $updateRoute = route('admin.kabupaten.kontak.update');
    }
@endphp

{{-- PERBAIKAN: Judul halaman sekarang dinamis menggunakan $tenant --}}
@section('title', 'Kelola Kontak & Sosmed - ' . $tenant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-800">
                Kelola Kontak & Sosial Media
            </h1>
            {{-- PERBAIKAN: Deskripsi juga dinamis --}}
            <p class="mt-1 text-lg text-gray-600">
                Anda sedang mengubah data untuk: <span class="font-semibold text-gray-900">{{ $tenant->name }}</span>
            </p>
        </div>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg" role="alert">
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- PERBAIKAN: Form action menggunakan variabel $updateRoute yang sudah disiapkan --}}
        <form action="{{ $updateRoute }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                {{-- Informasi Kontak --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Informasi Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                            {{-- PERBAIKAN: Semua $kecamatan diubah menjadi $tenant --}}
                            <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $tenant->telepon) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]" placeholder="(0260) 123456">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $tenant->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]" placeholder="info@instansi.go.id">
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor</label>
                        <textarea name="alamat" id="alamat" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">{{ old('alamat', $tenant->alamat) }}</textarea>
                    </div>
                </div>

                {{-- Link Sosial Media --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Sosial Media</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="link_facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                            <input type="url" name="link_facebook" id="link_facebook" value="{{ old('link_facebook', $tenant->link_facebook) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]" placeholder="https://facebook.com/namaakun">
                        </div>
                        <div>
                            <label for="link_twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter (X)</label>
                            <input type="url" name="link_twitter" id="link_twitter" value="{{ old('link_twitter', $tenant->link_twitter) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]" placeholder="https://x.com/namaakun">
                        </div>
                        <div>
                            <label for="link_youtube" class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                            <input type="url" name="link_youtube" id="link_youtube" value="{{ old('link_youtube', $tenant->link_youtube) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]" placeholder="https://youtube.com/c/namaakun">
                        </div>
                        <div>
                            <label for="link_instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                            <input type="url" name="link_instagram" id="link_instagram" value="{{ old('link_instagram', $tenant->link_instagram) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]" placeholder="https://instagram.com/namaakun">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200">
                <button type="submit" class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection