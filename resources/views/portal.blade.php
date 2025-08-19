@extends('layouts.app')

@section('title', 'Portal Digital Kabupaten Subang')

@push('styles')
{{-- Leaflet CSS untuk Peta Interaktif --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
{{-- Swiper CSS untuk Slider --}}
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<style>
    /* Gaya untuk Hero Section dan Kartu Berita */
    .hero-bg {
        background-image: linear-gradient(to bottom, rgba(17, 24, 39, 0.8), rgba(17, 24, 39, 0.9)), url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?q=80&w=2070&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Animasi */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    .anim-fade-in-down {
        opacity: 0;
        animation: fadeInDown 0.8s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    /* Styling untuk Peta Interaktif - DIPERBAIKI */
    #map {
        height: 600px;
        width: 100%;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        z-index: 1;
        position: relative;
    }

    /* Fix untuk container peta */
    .map-container {
        position: relative;
        z-index: 1;
    }

    .leaflet-popup-content a {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 12px;
        background-color: #1E4E7C;
        color: white;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .leaflet-popup-content a:hover {
        background-color: #163a5f;
    }

    .leaflet-tooltip.kecamatan-tooltip {
        background-color: rgba(255, 255, 255, 0.9);
        border: 1px solid #1E4E7C;
        border-radius: 4px;
        color: #1E4E7C;
        padding: 4px 8px;
        font-weight: 700;
        font-size: 12px;
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    /* Styling untuk daftar kecamatan */
    .kecamatan-list {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        max-height: 540px;
        overflow-y: auto;
    }

    .kecamatan-item {
        display: block;
        padding: 12px 16px;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
    }

    .kecamatan-item:hover {
        background-color: #1E4E7C;
        color: white;
    }

    .kecamatan-item:last-child {
        border-bottom: none;
    }

    /* Styling untuk input pencarian */
    .search-input {
        width: 100%;
        padding-left: 2.5rem;
        padding-right: 1rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease-in-out;
    }

    .search-input:focus {
        outline: none;
        ring: 2px;
        ring-color: #1E4E7C;
        border-color: #1E4E7C;
    }
</style>
@endpush

@section('content')

{{-- ====================================================================== --}}
{{-- Panel Kontrol Superadmin (Versi Final)
{{-- ====================================================================== --}}
@role('super-admin')
<div class="bg-[#1e4e7c] text-white shadow-lg">
    <div
        class="container mx-auto px-6 py-3 flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
        <div class="mb-2 sm:mb-0">
            <h2 class="font-bold text-lg">Panel Kontrol Superadmin</h2>
            <p class="text-sm opacity-80">Manajemen konten global dan kewilayahan.</p>
        </div>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm flex items-center">
                <i class="fas fa-cogs mr-2"></i>
                <span>Menu Manajemen</span>
                <i class="fas fa-chevron-down ml-2 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-72 origin-top-right bg-white rounded-md shadow-lg z-50 text-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
                style="display: none;">
                <div class="py-1">
                    <div class="px-4 py-2 text-xs text-gray-400">Manajemen Konten Kabupaten</div>

                    <a href="{{ route('admin.kabupaten.berita.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Berita</a>
                    <a href="{{ route('admin.kabupaten.banner.edit') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Banner</a>
                    <a href="{{ route('admin.kabupaten.kontak.edit') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Kontak</a>

                    <div class="border-t border-gray-100 my-1"></div>

                    <div class="px-4 py-2 text-xs text-gray-400">Navigasi Halaman Kabupaten</div>

                    <a href="{{ route('admin.kabupaten.profil.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Profil</a>
                    <a href="{{ route('admin.kabupaten.pemerintahan.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Pemerintahan</a>
                    <a href="{{ route('admin.kabupaten.wisata.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Wisata</a>
                    <a href="{{ route('admin.kabupaten.laporan-keuangan.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Laporan Keuangan</a>
                    <a href="{{ route('admin.kabupaten.infografis.index') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Infografis</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endrole

{{-- HERO SECTION --}}
@php
$banner = $kabupaten->banner_url ?? null;
$banner_type = $kabupaten->banner_type ?? null;
$video_id = $kabupaten->youtube_video_id ?? null;
@endphp

<div
    class="relative w-full h-[60vh] md:h-[50vh] text-white flex items-center justify-center text-center overflow-hidden">

    {{-- LAYER 1: Latar Belakang Dinamis (Paling Belakang) --}}
    <div class="absolute inset-0 w-full h-full bg-black z-0">
        @if ($banner_type === 'image_file' && $banner)
        <div class="absolute inset-0 w-full h-full bg-cover bg-center"
            style="background-image: url('{{ asset('storage/' . $banner) }}');"></div>
        @elseif ($banner_type === 'video_file' && $banner)
        <video
            class="absolute top-1/2 left-1/2 w-auto h-auto min-w-full min-h-full object-cover transform -translate-x-1/2 -translate-y-1/2"
            autoplay loop muted playsinline>
            <source src="{{ asset('storage/' . $banner) }}" type="video/mp4">
        </video>
        @elseif ($banner_type === 'youtube' && $video_id)
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <iframe class="w-full h-full scale-[1.3]"
                src="https://www.youtube.com/embed/{{ $video_id }}?autoplay=1&mute=1&loop=1&playlist={{ $video_id }}&controls=0&showinfo=0&autohide=1&modestbranding=1&iv_load_policy=3&rel=0"
                frameborder="0" allow="autoplay; encrypted-media"></iframe>
        </div>
        @else
        {{-- Tampilan Default jika tidak ada banner --}}
        <div class="absolute inset-0 w-full h-full bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?q=80&w=2070&auto=format&fit=crop');">
        </div>
        @endif
    </div>

    {{-- LAYER 2: Lapisan Overlay Gelap (Di Tengah) --}}
    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 z-10"></div>

    {{-- LAYER 3: Konten Teks (Paling Depan) --}}
    <div class="relative container mx-auto px-6 z-20">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 anim-fade-in-down"
            style="--anim-delay: 200ms;">
            Portal Digital Kabupaten Subang
        </h1>
        <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto anim-fade-in-up" style="--anim-delay: 400ms;">
            Temukan informasi dan layanan terintegrasi dari 30 kecamatan<br>
            di bawah satu atap untuk mewujudkan<br>
            <span class="font-bold">SUBANG JAWARA!!</span>
        </p>
        <a href="#jelajahi"
            class="mt-8 inline-block bg-[#1E4E7C] text-white font-bold py-3 px-8 rounded-full text-sm uppercase transition-all duration-300 ease-in-out hover:brightness-90 hover:shadow-lg hover:-translate-y-1 active-scale-95 anim-fade-in-up"
            style="--anim-delay: 600ms;">
            Jelajahi Sekarang
        </a>
    </div>
</div>

{{-- BAGIAN KONTEN UTAMA --}}
<div class="bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative z-10">

        {{-- BAGIAN BERITA TERKINI --}}
        <div class="mb-20">
            <h2 class="text-3xl font-bold text-white drop-shadow text-center mb-10 anim-fade-in-up"
                style="--anim-delay: 600ms;">Berita Terkini</h2>
            @if($beritaTerkini->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($beritaTerkini as $berita)
                <div class="anim-fade-in-up" style="--anim-delay: {{ 700 + ($loop->iteration * 100) }}ms;">
                    <a href="{{ route('berita.show', $berita->slug) }}"
                        class="block bg-white rounded-lg shadow-lg overflow-hidden card-hover transition-all duration-300 group h-full">
                        <div class="overflow-hidden">
                            <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/600x400/e2e8f0/64748b?text=Berita' }}"
                                alt="{{ $berita->judul }}"
                                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <span class="text-xs font-semibold text-white bg-[#1E4E7C] px-3 py-1 rounded-full">
                                {{ $berita->kategori->nama ?? 'Umum' }}
                            </span>
                            <h3
                                class="mt-3 text-lg font-bold text-gray-900 leading-tight group-hover:text-[#1E4E7C] transition-colors">
                                {{ $berita->judul }}</h3>
                            <p class="mt-2 text-gray-600 text-sm">
                                {{ Str::limit(strip_tags($berita->excerpt), 100) }}
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12 anim-fade-in-up">
                <a href="{{ route('berita.index') }}"
                    class="bg-[#1E4E7C] text-white font-bold py-3 px-8 rounded-full hover:bg-[#163a5f] transition-colors duration-300">
                    Lihat Semua Berita
                </a>
            </div>
            @else
            <div class="bg-white rounded-lg p-12 text-center text-gray-500 shadow-md anim-fade-in-up">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum Ada Berita Terbaru</h3>
                <p class="mt-1 text-sm text-gray-500">Silakan cek kembali nanti untuk mendapatkan informasi terkini dari
                    Kabupaten Subang.</p>
            </div>
            @endif
        </div>

        {{-- BAGIAN JELAJAHI KECAMATAN DENGAN PETA INTERAKTIF + PENCARIAN --}}
        <div id="jelajahi" x-data="mapSearch()" x-init="init()"
            class="bg-white text-gray-800 rounded-lg p-8 md:p-12 shadow-lg" style="z-index: 1;">
            <h2 class="text-3xl font-bold text-center mb-4">Jelajahi Wilayah Kecamatan</h2>
            <p class="text-center text-gray-600 mb-8 max-w-2xl mx-auto">Gunakan peta untuk eksplorasi visual atau klik
                daftar di samping untuk pencarian cepat.</p>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Peta (3/4 bagian) --}}
                <div class="lg:col-span-3 order-2 lg:order-1">
                    <div class="map-container">
                        <div id="map"></div>
                    </div>
                </div>

                {{-- Daftar Kecamatan (1/4 bagian) --}}
                <div class="lg:col-span-1 order-1 lg:order-2">
                    <div class="relative mb-4">
                        <input type="text" x-model="searchQuery" placeholder="Cari kecamatan..." class="search-input">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="kecamatan-list">
                        <template x-for="kecamatan in filteredKecamatans" :key="kecamatan.slug">
                            <a @click.prevent="selectKecamatan(kecamatan.slug)" class="kecamatan-item"
                                x-text="kecamatan.name"></a>
                        </template>

                        {{-- Pesan jika tidak ada hasil pencarian --}}
                        <div x-show="filteredKecamatans.length === 0 && searchQuery !== ''"
                            class="p-4 text-center text-gray-500">
                            <p>Tidak ada kecamatan yang ditemukan</p>
                        </div>
                    </div>

                    {{-- Info jumlah kecamatan --}}
                    <div class="mt-4 text-sm text-gray-600 text-center">
                        <span x-text="filteredKecamatans.length"></span> dari <span
                            x-text="allKecamatans.length"></span> kecamatan
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- = [REDESIGN] BAGIAN JELAJAHI PERANGKAT DAERAH (GRID INTERAKTIF) = --}}
        {{-- ====================================================== --}}
        <style>
            /* CSS untuk desain kartu list-grid yang baru */
            .pd-list-card {
                background-color: #ffffff;
                border-radius: 0.5rem;
                /* 8px */
                padding: 1rem;
                /* 16px */
                border: 1px solid #e5e7eb;
                /* border-gray-200 */
                transition: all 0.2s ease-in-out;
                display: flex;
                align-items: center;
                text-decoration: none;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }

            .pd-list-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 4px 6px -1px rgba(30, 78, 124, 0.1), 0 2px 4px -2px rgba(30, 78, 124, 0.07);
                border-color: #93c5fd;
                /* border-blue-300 */
                background-color: #f7fafc;
                /* bg-gray-50 */
            }

            .pd-list-card .icon-container {
                width: 3rem;
                /* 48px */
                height: 3rem;
                /* 48px */
                flex-shrink: 0;
                border-radius: 0.5rem;
                /* 8px */
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f0f4f8;
                /* Warna latar ikon yang lembut */
                color: #1E4E7C;
                /* Warna aksen utama */
                margin-right: 1rem;
                /* 16px */
                transition: all 0.2s ease-in-out;
            }

            .pd-list-card:hover .icon-container {
                background-color: #1E4E7C;
                color: #ffffff;
            }

            .pd-list-card .pd-name {
                font-weight: 600;
                /* font-semibold */
                color: #1f2937;
                /* text-gray-800 */
                line-height: 1.4;
                text-align: left;
            }

            .pd-list-card .arrow-icon {
                margin-left: auto;
                color: #9ca3af;
                /* text-gray-400 */
                transition: all 0.2s ease-in-out;
                opacity: 0;
                transform: translateX(-5px);
            }

            .pd-list-card:hover .arrow-icon {
                opacity: 1;
                transform: translateX(0);
                color: #1E4E7C;
            }

            /* Style untuk wrapper/frame */
            .pd-wrapper {
                background-color: #f9fafb;
                /* bg-gray-50 */
                border: 1px solid #e5e7eb;
                /* border-gray-200 */
                border-radius: 0.75rem;
                /* 12px */
                padding: 2rem;
                /* 32px */
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            }

            /* Style untuk search input */
            .pd-search-input {
                width: 100%;
                max-width: 320px;
                padding-left: 2.5rem;
                padding-right: 1rem;
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                border: 1px solid #d1d5db;
                border-radius: 9999px;
                /* rounded-full */
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                transition: all 0.2s ease-in-out;
            }

            .pd-search-input:focus {
                outline: none;
                box-shadow: 0 0 0 2px #bfdbfe;
                /* ring-2 ring-blue-200 */
                border-color: #3b82f6;
                /* border-blue-500 */
            }
        </style>

        <div class="my-20 anim-fade-in-up" style="--anim-delay: 400ms;" x-data="perangkatDaerahSearch()">
            <div class="pd-wrapper">
                {{-- Header dengan Judul dan Search Bar --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl font-bold text-gray-800">Jelajahi Perangkat Daerah</h2>
                        <p class="text-gray-500 mt-1 text-sm">
                            Temukan dinas atau badan yang Anda cari.
                        </p>
                    </div>
                    <div class="relative w-full md:w-auto">
                        <input type="text" x-model="search" @input="limit = 6" placeholder="Cari perangkat daerah..."
                            class="pd-search-input">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                @if($perangkatDaerahs->isNotEmpty())
                {{-- Grid yang lebih luas: 1 kolom di mobile, 2 di tablet, 3 di layar besar --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Loop menggunakan Alpine.js untuk filtering dinamis --}}
                    <template x-for="perangkat in paginatedItems" :key="perangkat.slug">
                        <a :href="generateUrl(perangkat.slug)" class="pd-list-card">
                            <div class="icon-container">
                                <i class="fas fa-building-shield fa-lg"></i>
                            </div>
                            <span class="pd-name text-sm" x-text="perangkat.name"></span>
                            <div class="arrow-icon">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </template>
                </div>

                {{-- Pesan jika pencarian tidak ditemukan --}}
                <div x-show="filteredItems.length === 0 && search !== ''" class="text-center text-gray-500 py-10">
                    <p>Perangkat daerah tidak ditemukan.</p>
                </div>

                {{-- Tombol "Tampilkan Lebih Banyak" dan "Tampilkan Lebih Sedikit" --}}
                <div class="flex justify-center items-center gap-4 mt-8">
                    <div x-show="limit < filteredItems.length">
                        <button @click="limit += 6"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-full transition">
                            Tampilkan Lebih Banyak
                        </button>
                    </div>
                    <div x-show="limit > 6 && search === ''">
                        {{-- ====================================================== --}}
                        {{-- = PERBAIKAN LOGIKA ADA DI SINI ========================= --}}
                        {{-- ====================================================== --}}
                        <button @click="limit -= 6"
                            class="bg-white hover:bg-gray-100 text-gray-600 font-semibold py-2 px-6 rounded-full transition border border-gray-300">
                            Tampilkan Lebih Sedikit
                        </button>
                    </div>
                </div>
                @else
                <p class="text-center text-gray-500 py-10">
                    Data perangkat daerah belum tersedia.
                </p>
                @endif
            </div>
        </div>

        <script>
            function perangkatDaerahSearch() {
        return {
            search: '',
            limit: 6, // Jumlah item yang ditampilkan awalnya
            allItems: @json($perangkatDaerahs->map->only(['name', 'slug'])),

            get filteredItems() {
                if (this.search === '') {
                    return this.allItems;
                }
                return this.allItems.filter(item =>
                    item.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            get paginatedItems() {
                // Jika ada pencarian, tampilkan semua hasil tanpa batasan
                if (this.search !== '') {
                    return this.filteredItems;
                }
                return this.filteredItems.slice(0, this.limit);
            },

            generateUrl(slug) {
                const domain = "{{ env('APP_DOMAIN', 'subang.go.id') }}";
                const port = window.location.port;
                const scheme = window.location.protocol;
                let url = `${scheme}//${slug}.${domain}`;
                if (port && !['80', '443'].includes(port)) {
                    url += `:${port}`;
                }
                return url;
            }
        }
    }
        </script>
        {{-- ====================================================== --}}
        {{-- = AKHIR BAGIAN BARU = --}}
        {{-- ====================================================== --}}


    </div>
</div>
@endsection

@push('scripts-footer')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    function mapSearch() {
        return {
            searchQuery: '',
            map: null,
            markers: {},
            activeMarker: null,
            activeSlug: null,
            
            allKecamatans: @isset($kecamatans) 
                @json($kecamatans->map(fn($kec) => ['name' => $kec->name, 'slug' => $kec->slug])->values())
            @else 
                [] 
            @endisset,
            
            coordinates: {
                'binong': [-6.4021, 107.8015], 'blanakan': [-6.2458, 107.6581], 'ciasem': [-6.3353, 107.7024],
                'ciater': [-6.7162, 107.6539], 'cibogo': [-6.4897, 107.7562], 'cijambe': [-6.5873, 107.8341],
                'cikaum': [-6.4533, 107.8899], 'cipeundeuy': [-6.5511, 107.9507], 'cipunagara': [-6.3892, 107.9836],
                'cisalak': [-6.8014, 107.7593], 'compreng': [-6.3725, 107.8548], 'dawuan': [-6.5381, 107.8872],
                'jalancagak': [-6.7005, 107.7317], 'kalijati': [-6.5529, 107.6683], 'kasomalang': [-6.7566, 107.7031],
                'legonkulon': [-6.2045, 107.7513], 'pabuaran': [-6.4827, 107.8519], 'pagaden': [-6.4398, 107.8102],
                'pagaden-barat': [-6.4589, 107.7654], 'pamanukan': [-6.2829, 107.8118], 'patokbeusi': [-6.4316, 107.6591],
                'purwadadi': [-6.4277, 107.9105], 'pusakajaya': [-6.3421, 107.9087], 'pusakanagara': [-6.2694, 107.9011],
                'sagalaherang': [-6.7328, 107.7086], 'serangpanjang': [-6.6851, 107.6047], 'subang': [-6.5710, 107.7602],
                'sukasari': [-6.3072, 107.8533], 'tambakdahan': [-6.3865, 107.9158], 'tanjungsiang': [-6.7839, 107.8152]
            },
            
            get filteredKecamatans() {
                if (this.searchQuery === '') return this.allKecamatans;
                return this.allKecamatans.filter(k => k.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
            },

            selectKecamatan(slug) {
                this.activeSlug = slug;
                if (this.activeMarker) { this.activeMarker.setZIndexOffset(0); }

                const marker = this.markers[slug];
                if (marker) {
                    this.map.flyTo(marker.getLatLng(), 13, { duration: 1.5 });
                    marker.setZIndexOffset(1000);
                    setTimeout(() => marker.openPopup(), 800);
                    this.activeMarker = marker;
                }
            },

            init() {
                this.$nextTick(() => this.initializeMap());
            },
            
            initializeMap() {
                if (document.getElementById('map') && !this.map) {
                    this.map = L.map('map').setView([-6.57, 107.76], 10);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(this.map);
                    
                    // ======================================================================
                    // === PERBAIKAN UTAMA ADA DI SINI ======================================
                    // ======================================================================
                    // 1. Kita buat sebuah 'template' URL menggunakan Blade, dengan placeholder.
                    const urlTemplate = "{{ route('kecamatan.show', ['kecamatan' => 'SLUG_PLACEHOLDER']) }}";

                    this.allKecamatans.forEach(kecamatan => {
                        const coord = this.coordinates[kecamatan.slug];
                        if (coord) {
                            const marker = L.marker(coord, { title: kecamatan.name }).addTo(this.map);
                            marker.bindTooltip(kecamatan.name, { direction: 'top', className: 'kecamatan-tooltip', offset: [0, -10] });

                            // 2. Ganti placeholder dengan slug kecamatan yang sebenarnya untuk setiap marker.
                            const finalUrl = urlTemplate.replace('SLUG_PLACEHOLDER', kecamatan.slug);

                            // 3. Gunakan URL yang sudah benar di dalam popup.
                            marker.bindPopup(
                                `<div class='text-center'><strong class='text-lg'>Kecamatan ${kecamatan.name}</strong><br>` +
                                `<a href='${finalUrl}' class='mt-2 inline-block bg-[#1E4E7C] text-white px-3 py-1 rounded-full text-sm font-semibold'>Kunjungi Halaman</a></div>`
                            );
                            marker.on('click', () => this.selectKecamatan(kecamatan.slug));
                            this.markers[kecamatan.slug] = marker;
                        }
                    });
                    setTimeout(() => this.map.invalidateSize(), 100);
                }
            }
        };
    }

    // Inisialisasi Swiper untuk slider Perangkat Daerah
    document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.perangkat-daerah-slider', {
        loop: false,
        slidesPerView: 1.5, // Menampilkan 1.5 kartu untuk mobile
        spaceBetween: 15,
        navigation: {
            nextEl: '.perangkat-daerah-slider .swiper-button-next',
            prevEl: '.perangkat-daerah-slider .swiper-button-prev',
        },
        pagination: { // Menambahkan Pagination (indikator titik-titik)
            el: '.perangkat-daerah-slider .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 3, spaceBetween: 20 },
            768: { slidesPerView: 4, spaceBetween: 30 },
            1024: { slidesPerView: 5, spaceBetween: 30 },
        }
    });
});
</script>
@endpush