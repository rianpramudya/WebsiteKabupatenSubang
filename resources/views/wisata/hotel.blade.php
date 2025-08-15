@extends('layouts.app')

@section('title', 'Hotel - ' . (isset($currentKecamatan) ? $currentKecamatan->name : 'Kabupaten Subang'))

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

<div class="w-full relative text-center bg-cover bg-center py-24 md:py-28"
    style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop');">
    {{-- WARNA DIUBAH --}}
    <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down" style="--anim-delay: 200ms;">Akomodasi Hotel</h1>
    <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
        {{ isset($currentKecamatan) ? 'Kecamatan ' . $currentKecamatan->name : 'Kabupaten Subang' }}
    </p>
</div>

<div class="bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <form action="{{ url()->current() }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm anim-fade-in-left" style="--anim-delay: 600ms;">
                    <div class="relative">
                        {{-- WARNA DIUBAH --}}
                        <input type="text" name="search" placeholder="Cari nama hotel..." value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md focus:ring-[#1E4E7C] focus:border-[#1E4E7C] pl-10">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>

                @forelse ($hotels as $item)
                <div class="block bg-white p-5 rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 group anim-fade-in-up" @style(['--anim-delay' => (700 + ($loop->iteration * 150)) . 'ms'])>
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-full sm:w-1/3 h-48 sm:h-auto overflow-hidden rounded-lg">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300/e2e8f0/64748b?text=Gambar+Hotel' }}"
                                alt="{{ $item->nama }}"
                                class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                {{-- WARNA DIUBAH --}}
                                <h2 class="text-2xl font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors">{{ $item->nama }}</h2>
                                @if($item->bintang)
                                {{-- WARNA DIUBAH --}}
                                <div class="flex items-center bg-[#FCE405] text-[#1E4E7C] text-xs font-bold px-2 py-1 rounded-md">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>{{ $item->bintang }}</span>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-1 mb-3"><i class="fas fa-map-marker-alt mr-1"></i> {{ $item->alamat }}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit(strip_tags($item->deskripsi), 200) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-10 rounded-lg shadow-sm text-center anim-fade-in-up" style="--anim-delay: 700ms;">
                    <i class="fas fa-search-minus text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-semibold">Hotel tidak ditemukan.</p>
                </div>
                @endforelse

                @if ($hotels->hasPages())
                <div class="mt-8 anim-fade-in-up" @style(['--anim-delay' => (800 + ($hotels->count() * 150)) . 'ms'])>{{ $hotels->links() }}</div>
                @endif
            </div>

            <aside class="lg:col-span-1 space-y-6">
                <div class="bg-white p-5 rounded-lg shadow-sm sticky top-24 anim-fade-in-right" style="--anim-delay: 600ms;">
                    {{-- WARNA DIUBAH --}}
                    <h3 class="font-bold text-lg border-b pb-3 mb-4 text-[#1E4E7C]">Berita Terkini</h3>
                    <ul class="space-y-4">
                        @forelse ($berita_terkini as $berita)
                        <li class="anim-fade-in-up" @style(['--anim-delay' => (700 + ($loop->iteration * 150)) . 'ms'])>
                            <a href="#" class="flex items-center gap-4 group">
                                <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/150x150/e2e8f0/64748b?text=Berita' }}" alt="{{ $berita->judul }}" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                <div class="flex-1">
                                    {{-- WARNA DIUBAH --}}
                                    <p class="text-sm font-semibold text-gray-800 group-hover:text-[#FF3B00] leading-tight transition-colors">{{ $berita->judul }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $berita->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="text-sm text-gray-400 text-center py-4 anim-fade-in-up" style="--anim-delay: 700ms;">Belum ada berita terkini.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection