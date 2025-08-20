@extends('layouts.app')

@section('title', $berita->judul)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .prose img {
        border-radius: 0.5rem;
    }

    .anim-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }
</style>
@endpush

@section('content')

<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <nav class="text-sm mb-6 text-gray-500">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
                <span class="mx-2">></span>
                <a href="{{ route('berita.index') }}" class="hover:underline">Berita</a>
            </nav>

            <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E4E7C] tracking-tight mb-3">
                {{ $berita->judul }}
            </h1>

            <div class="flex items-center text-sm text-gray-500 mb-8 pb-8 border-b">
                {{-- Menggunakan isoFormat untuk nama bulan dalam Bahasa Indonesia --}}
                <span>Dipublikasikan pada {{ \Carbon\Carbon::parse($berita->published_at)->isoFormat('D MMMM YYYY,
                    HH:mm') }}</span>
                <span class="mx-2">|</span>
                <span class="font-semibold text-[#1E4E7C]">{{ $berita->kategori->nama ?? 'Tanpa Kategori' }}</span>
                <span class="mx-2">|</span>
                <span><i class="fas fa-eye mr-1"></i> {{ $berita->views }}x dilihat</span>
            </div>

            @if($berita->gambar)
            <div class="mb-8">
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar {{ $berita->judul }}"
                    class="w-full rounded-lg shadow-lg"
                    onerror="this.onerror=null;this.src='https://placehold.co/1200x600/e2e8f0/64748b?text=Gambar+Utama';">
            </div>
            @endif

            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! $berita->isi !!}
            </div>

            @if($berita->tags->isNotEmpty())
<div class="mt-10 pt-6 border-t">
    <div class="flex items-center gap-2 flex-wrap">
        <h4 class="font-bold text-gray-800 mr-2">Tags:</h4>
        @foreach($berita->tags as $tag)
            @php
                $route = '';
                // Cek apakah berita ini milik sebuah Kecamatan
                if ($berita->kecamatan) {
                    $route = route('berita.tags.kecamatan.index', [
                        'kecamatan' => $berita->kecamatan->slug, 
                        'tag' => $tag->slug
                    ]);
                // Cek apakah berita ini milik sebuah Perangkat Daerah
                } elseif ($berita->perangkatDaerah) {
                    $route = route('berita.tags.perangkat.index', [
                        'perangkatDaerah' => $berita->perangkatDaerah->slug, 
                        'tag' => $tag->slug
                    ]);
                // Jika bukan keduanya, gunakan route global (Kabupaten)
                } else {
                    $route = route('berita.tags.index', ['tag' => $tag->slug]);
                }
            @endphp
            <a href="{{ $route }}"
                class="bg-gray-100 text-[#1E4E7C] text-sm font-medium px-3 py-1.5 rounded-full hover:bg-gray-200 transition-colors">
                #{{ $tag->name }}
            </a>
        @endforeach
    </div>
</div>
@endif

            <div class="mt-10 pt-6 {{ $berita->tags->isEmpty() ? 'border-t' : '' }}">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center">
                        <h4 class="font-bold text-gray-800 mr-4">Bagikan:</h4>
                        <div class="flex space-x-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="bg-sky-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-sky-600 transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}"
                                target="_blank"
                                class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-600 transition">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        @can('update', $berita)
                        @php
                        // Cek apakah berita ini memiliki kecamatan atau tidak
                        if ($berita->kecamatan) {
                        // [PERBAIKAN] Gunakan nama rute yang benar: 'admin.kecamatan.berita.edit'
                        $editRoute = route('admin.kecamatan.berita.edit', ['kecamatan' => $berita->kecamatan->slug,
                        'berita' => $berita]);
                        } elseif ($berita->perangkatDaerah) {
                        // [PERBAIKAN] Tambahkan logika untuk Perangkat Daerah
                        $editRoute = route('admin.perangkat-daerah.berita.edit', ['perangkatDaerah' =>
                        $berita->perangkatDaerah->slug, 'berita' => $berita]);
                        } else {
                        // Jika tidak keduanya, gunakan route edit untuk tingkat kabupaten
                        $editRoute = route('admin.kabupaten.berita.edit', $berita);
                        }
                        @endphp
                        <a href="{{ $editRoute }}"
                            class="inline-block bg-[#FF3B00] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        @endcan
                        <a href="{{ route('berita.download', $berita) }}"
                            class="inline-block bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                            <i class="fas fa-download mr-2"></i> Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($beritaTerkait->isNotEmpty())
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-[#1E4E7C] mb-8">Berita Terkait</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritaTerkait as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden group anim-fade-in-up"
                style="--anim-delay: {{ $loop->iteration * 150 }}ms;">
                <a href="{{ route('berita.show', $item->slug) }}" class="block">
                    <div class="overflow-hidden">
                        <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/600x400/cccccc/ffffff?text=Gambar' }}"
                            alt="Gambar {{ $item->judul }}"
                            class="w-full h-40 object-cover transform transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-md text-gray-900 group-hover:text-[#FF3B00] transition-colors">
                            {{ Str::limit($item->judul, 60) }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($item->published_at)->isoFormat('D MMMM YYYY') }}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection