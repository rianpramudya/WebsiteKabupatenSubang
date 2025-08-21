@extends('layouts.app')

@section('title', 'Objek Wisata - ' . (isset($currentKecamatan) ? $currentKecamatan->name : 'Kabupaten Subang'))

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
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

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .anim-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.7s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    .anim-fade-in-down {
        opacity: 0;
        animation: fadeInDown 0.7s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    .anim-fade-in-left {
        opacity: 0;
        animation: fadeInLeft 0.7s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    .anim-fade-in-right {
        opacity: 0;
        animation: fadeInRight 0.7s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-50">
    <div class="relative text-center bg-cover bg-center py-24 md:py-28"
        style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=2070&auto=format&fit=crop');">
        {{-- WARNA DIUBAH --}}
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down"
            style="--anim-delay: 200ms;">Objek Wisata</h1>
        <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
            {{ isset($currentKecamatan) ? 'Kecamatan ' . $currentKecamatan->name : 'Kabupaten Subang' }}
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Bagian konten utama --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="relative z-20 bg-white p-6 rounded-2xl shadow-lg mb-10 anim-fade-in-up"
                    style="--anim-delay: 600ms;">
                    <form action="{{ url()->current() }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="md:col-span-1">
                            <div class="relative">
                                {{-- WARNA DIUBAH --}}
                                <input type="text" name="search" placeholder="Cari nama objek wisata..."
                                    value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#1E4E7C] focus:border-[#1E4E7C] shadow-sm placeholder-gray-400">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ open: false, selected: '{{ request('kategori') ? $kategori_filter->firstWhere(fn($k) => $k == request('kategori')) : 'Semua Kategori' }}' }"
                            class="relative md:col-span-1">
                            {{-- WARNA DIUBAH --}}
                            <button type="button" @click="open = !open"
                                class="w-full flex justify-between items-center bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1E4E7C] transition">
                                <span x-text="selected || 'Semua Kategori'"></span>
                                <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                class="absolute mt-2 w-full bg-white rounded-xl shadow-lg z-10 overflow-hidden border border-gray-200">
                                <a href="?search={{ request('search') }}"
                                    @click="selected = 'Semua Kategori'; open = false"
                                    class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 {{ request('kategori') == '' ? 'bg-gray-100 font-semibold' : '' }}">Semua
                                    Kategori</a>
                                @foreach ($kategori_filter as $kategori)
                                <a href="?search={{ request('search') }}&kategori={{ $kategori }}"
                                    @click="selected = '{{ $kategori }}'; open = false"
                                    class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 {{ request('kategori') == $kategori ? 'bg-gray-100 font-semibold' : '' }}">{{
                                    $kategori }}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="md:col-span-1 flex justify-start md:justify-end">
                            {{-- WARNA DIUBAH --}}
                            <button type="submit"
                                class="bg-[#1E4E7C] hover:brightness-90 text-white font-semibold px-6 py-2 rounded-full transition duration-200 shadow-md">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($objek_wisatas as $wisata)
                    <div class="bg-white rounded-2xl shadow hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden group anim-fade-in-up"
                        @style(['--anim-delay'=> (700 + ($loop->iteration * 150)) . 'ms'])>
                        <a href="#">
                            <div class="relative">
                                <img src="{{ $wisata->gambar ? asset('storage/' . $wisata->gambar) : 'https://placehold.co/600x400/e2e8f0/64748b?text=Wisata' }}"
                                    alt="{{ $wisata->nama }}"
                                    class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                                @if($wisata->is_unggulan)
                                {{-- WARNA DIUBAH --}}
                                <span
                                    class="absolute top-2 right-2 bg-[#FCE405] text-[#1E4E7C] text-xs font-bold px-3 py-1 rounded-lg shadow-sm">Unggulan</span>
                                @endif
                            </div>
                            <div class="p-5">
                                {{-- WARNA DIUBAH --}}
                                <p class="text-sm font-medium text-[#1E4E7C]">{{ $wisata->kategori }}</p>
                                <h3
                                    class="mt-1 text-lg font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors truncate">
                                    {{ $wisata->nama }}</h3>
                                <p class="text-sm text-gray-500 mt-1 flex items-center"><i
                                        class="fas fa-map-marker-alt mr-2 text-gray-400"></i>{{ $wisata->lokasi_teks }}
                                </p>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-xl shadow-sm anim-fade-in-up"
                        style="--anim-delay: 700ms;">
                        <i class="fas fa-map-signs text-5xl text-gray-300 mb-4"></i>
                        <p class="text-xl font-semibold text-gray-500">Objek Wisata Tidak Ditemukan</p>
                    </div>
                    @endforelse
                </div>

                @if ($objek_wisatas->hasPages())
                <div class="mt-12 anim-fade-in-up" @style(['--anim-delay'=> (800 + ($objek_wisatas->count() * 150)) .
                    'ms'])>{{ $objek_wisatas->links() }}</div>
                @endif
            </div>

            {{-- Menambahkan sidebar berita terkini --}}
            @include('partials.sidebar_berita_terkini')

        </div>
    </div>
</div>
@endsection