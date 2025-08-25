@extends('layouts.app')

{{-- 1. Blok PHP untuk judul dinamis --}}
@php
    $judulHalaman = 'Infografis Kabupaten Subang'; // Default

    if (isset($currentPerangkatDaerah)) {
        $judulHalaman = 'Infografis ' . $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan)) {
        $judulHalaman = 'Infografis Kecamatan ' . $currentKecamatan->name;
    }
@endphp

@section('title', $judulHalaman)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
@keyframes fadeInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }

.anim-fade-in-up { opacity: 0; animation: fadeInUp 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
.anim-fade-in-down { opacity: 0; animation: fadeInDown 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
.anim-fade-in-left { opacity: 0; animation: fadeInLeft 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
.anim-fade-in-right { opacity: 0; animation: fadeInRight 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
</style>
@endpush

@section('content')
{{-- [DIKEMBALIKAN] Menggunakan Alpine.js sederhana hanya untuk membuka/menutup modal --}}
<div x-data="{ openModal: false, imageUrl: '', imageTitle: '' }">
    {{-- Banner --}}
    <div class="w-full relative text-center bg-cover bg-center py-24 md:py-28"
        style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?w=900&auto=format&fit=crop&q=60');">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down" style="--anim-delay: 200ms;">
            {{ $judulHalaman }}
        </h1>
        <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
            Informasi visual mengenai data dan layanan publik.
        </p>
    </div>

    {{-- Konten --}}
    <div class="bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <form action="{{ url()->current() }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm anim-fade-in-left" style="--anim-delay: 600ms;">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Cari Infografis..." value="{{ request('search') }}"
                                    class="w-full border-gray-300 rounded-md focus:ring-[#1E4E7C] focus:border-[#1E4E7C] pl-10">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </form>

                    @forelse ($infografis as $item)
                    <div @click="openModal = true; imageUrl = '{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/800x1000/e2e8f0/64748b?text=Infografis' }}'; imageTitle = '{{ addslashes($item->judul) }}'"
                         class="block bg-white p-5 rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 group cursor-pointer anim-fade-in-up"
                         style="--anim-delay: {{ 700 + ($loop->iteration * 150) }}ms;">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="w-full sm:w-1/4 h-64 overflow-hidden rounded-lg">
                                <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x600/e2e8f0/64748b?text=Infografis' }}"
                                     alt="{{ $item->judul }}"
                                     class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors">{{ $item->judul }}</h2>
                                <p class="text-xs text-gray-500 mt-1 mb-3">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    Dipublikasikan pada {{ $item->published_at->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed">Klik untuk melihat gambar secara penuh.</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white p-10 rounded-lg shadow-sm text-center anim-fade-in-up" style="--anim-delay: 700ms;">
                        <i class="fas fa-search-minus text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 font-semibold">Infografis tidak ditemukan.</p>
                        <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci lain atau lihat kembali nanti.</p>
                    </div>
                    @endforelse

                    @if ($infografis->hasPages())
                    <div class="mt-8 anim-fade-in-up" style="--anim-delay: {{ 800 + ($infografis->count() * 150) }}ms;">
                        {{ $infografis->links() }}
                    </div>
                    @endif
                </div>

                @include('partials.sidebar_berita_terkini')
            </div>
        </div>
    </div>

    {{-- [PERBAIKAN] Mengubah posisi modal agar tidak tertutup navbar --}}
    <div x-show="openModal" @keydown.escape.window="openModal = false"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] flex items-start justify-center p-4 pt-32" style="display: none;">

        <div @click="openModal = false" class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>

        <div x-show="openModal"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[calc(100vh-12rem)] flex flex-col">

            {{-- Header Modal yang Selalu Terlihat --}}
            <div class="p-5 border-b flex justify-between items-center flex-shrink-0">
                <h3 class="font-semibold text-lg text-gray-800 truncate max-w-[85%]" x-text="imageTitle"></h3>
                <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            {{-- Kontainer Gambar dengan Scroll --}}
            <div class="flex-1 overflow-auto p-5 bg-gray-50">
                <img :src="imageUrl" alt="Infografis" class="w-full h-auto rounded-lg shadow" loading="lazy">
            </div>

            {{-- Footer Modal yang Selalu Terlihat --}}
            <div class="p-4 border-t text-right bg-white flex-shrink-0">
                <button @click="openModal = false" class="bg-[#1E4E7C] hover:brightness-90 text-white px-4 py-2 rounded-lg transition">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Menambahkan AlpineJS untuk fungsionalitas interaktif --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
