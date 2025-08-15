@php
// [PERBAIKAN] Logika lengkap untuk menangani semua level peran
// Variabel $tenant dikirim dari controller (bisa null untuk kabupaten)
if ($tenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
$routePrefix = $isKecamatan ? 'admin.kecamatan.berita' : 'admin.perangkat-daerah.berita';
$routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
} else {
$routePrefix = 'admin.kabupaten.berita';
$routeParameters = [];
}

// Membuat URL yang benar secara dinamis
$backRoute = route($routePrefix . '.index', $routeParameters);
$editRoute = route($routePrefix . '.edit', array_merge($routeParameters, ['berita' => $berita]));
@endphp

@extends('layouts.app')

@section('title', 'Detail Berita: ' . Str::limit($berita->judul, 30))

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h1 class="text-3xl font-bold text-[#1E4E7C] mb-4 sm:mb-0">Detail Berita</h1>
        <div>
            {{-- Tautan "Kembali" dan "Edit" sekarang menggunakan variabel yang sudah benar --}}
            <a href="{{ $backRoute }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">&larr; Kembali ke
                Daftar</a>
            <a href="{{ $editRoute }}"
                class="bg-[#FF3B00] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                <i class="fas fa-edit mr-2"></i>Edit Berita
            </a>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md">
        @if($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita"
            class="w-full h-auto max-h-96 object-cover rounded-md mb-6">
        @endif

        <h2 class="text-2xl font-bold text-[#1E4E7C] mb-2">{{ $berita->judul }}</h2>

        <div class="text-sm text-gray-500 mb-4 border-b pb-4">
            <span>Kategori: <span class="font-semibold text-[#1E4E7C]">{{ $berita->kategori->nama ?? 'N/A'
                    }}</span></span>
            @if(auth()->user()->hasRole('super-admin'))
            <span class="mx-2">|</span>
            <span>Pemilik: <span class="font-semibold">{{ $berita->kecamatan->name ?? ($berita->perangkatDaerah->name ??
                    'Kabupaten') }}</span></span>
            @endif
            <span class="mx-2">|</span>
            <span>Diterbitkan pada: {{ \Carbon\Carbon::parse($berita->published_at)->isoFormat('D MMMM YYYY') }}</span>
            <span class="mx-2">|</span>
            <span><i class="fas fa-eye mr-1"></i> Dilihat: <span class="font-semibold">{{ $berita->views }}
                    kali</span></span>
        </div>

        <div class="prose max-w-none text-gray-700 leading-relaxed mt-6">
            {!! $berita->isi !!}
        </div>
    </div>
</div>
@endsection