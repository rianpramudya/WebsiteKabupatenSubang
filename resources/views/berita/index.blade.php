@extends('layouts.app')

@php
$judulHalaman = 'Semua Berita'; // Default
$targetRoute = route('admin.kabupaten.berita.index'); // Default route admin

if (isset($currentPerangkatDaerah)) {
$judulHalaman = 'Berita ' . $currentPerangkatDaerah->name;
} elseif (isset($currentKecamatan)) {
$judulHalaman = 'Berita Kecamatan ' . $currentKecamatan->name;
$targetRoute = route('admin.kecamatan.berita.index', $currentKecamatan);
}
@endphp

@section('title', $judulHalaman)

@push('styles')
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

    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
</style>
@endpush

@section('content')

<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-[#1E4E7C] fade-in-up">
            {{ $judulHalaman }}
        </h1>
        <p class="text-gray-500 mt-2 fade-in-up" style="animation-delay: 0.2s;">
            Kumpulan informasi dan berita terkini.
        </p>

        @can('viewAny', \App\Models\Berita::class)
        @php
        $targetRoute = route('admin.kabupaten.berita.index');

        if (isset($currentKecamatan) && $currentKecamatan) {
        $targetRoute = route('admin.kecamatan.berita.index', ['kecamatan' => $currentKecamatan->slug]);
        }
        elseif (isset($currentPerangkatDaerah) && $currentPerangkatDaerah) {
        $targetRoute = route('admin.perangkat-daerah.berita.index', ['perangkatDaerah' =>
        $currentPerangkatDaerah->slug]);
        }
        @endphp

        <div class="mt-6 fade-in-up" style="animation-delay: 0.4s;">

            <a href="{{ $targetRoute }}"
                class="inline-block bg-[#1E4E7C] text-white font-bold py-2 px-5 rounded-lg text-sm hover:brightness-90 transition">
                <i class="fas fa-cog mr-2"></i> Kelola Berita
            </a>
        </div>
        @endcan
    </div>
</div>

<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($beritas as $berita)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col group fade-in-up"
            style="animation-delay: {{ 0.5 + ($loop->iteration * 0.1) }}s;">
            <div class="overflow-hidden">
                <a href="{{ route('berita.show', $berita->slug) }}">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar {{ $berita->judul }}"
                        class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110"
                        onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/64748b?text=No+Image';">
                </a>
            </div>
            <div class="p-6 flex-grow flex flex-col">
                <div class="flex-grow">
                    <div class="flex justify-between items-center text-xs mb-2">
                        <span class="font-semibold text-[#1E4E7C] uppercase">{{ $berita->kategori->nama ?? 'Tanpa
                            Kategori' }}</span>
                        <span class="text-gray-500">{{ \Carbon\Carbon::parse($berita->published_at)->isoFormat('D MMMM
                            YYYY') }}</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">
                        <a href="{{ route('berita.show', $berita->slug) }}"
                            class="hover:text-[#FF3B00] transition-colors">
                            {{ $berita->judul }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $berita->excerpt }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <p class="col-span-full text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
        @endforelse
    </div>

    @if ($beritas->hasPages())
    <div class="mt-12">
        {{ $beritas->links() }}
    </div>
    @endif
</div>
@endsection