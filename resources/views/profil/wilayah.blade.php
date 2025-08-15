@extends('layouts.app')

@php
    // [Disederhanakan] Penentuan nama konteks menjadi lebih ringkas
    $namaKonteks = 'Kabupaten Subang'; // Default
    if (isset($currentPerangkatDaerah)) {
        $namaKonteks = $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan) && $currentKecamatan->slug !== 'kabupaten-subang') {
        $namaKonteks = 'Kecamatan ' . $currentKecamatan->name;
    }
@endphp

@section('title', 'Profil Wilayah - ' . $namaKonteks)

@push('styles')
<style>
    .animated-fade {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .animated-fade.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-l-8 border-[#1E4E7C] animated-fade">
            <p class="text-sm uppercase text-gray-500 tracking-wider">Profil</p>
            <h1 class="text-3xl font-bold text-[#1E4E7C]">
                Wilayah {{ $namaKonteks }}
            </h1>
        </div>

        {{-- [FIX] Kondisi yang salah dihapus, sekarang menampilkan data untuk semua jenis tenant --}}
        @if($tenant)
            <div class="bg-white p-6 rounded-lg shadow-md mb-8 animated-fade">
                <h2 class="text-2xl font-bold text-[#1E4E7C] mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-[#1E4E7C]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Peta Wilayah
                </h2>
                <div class="rounded-lg overflow-hidden bg-gray-200 h-[500px]">
                    @if ($tenant->peta_url)
                    <iframe src="{{ $tenant->peta_url }}" width="100%" height="100%" style="border:0;" allowfullscreen
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                    @else
                    <div class="flex items-center justify-center h-full text-gray-500 text-center p-4 bg-gray-100">
                        <p>Peta wilayah untuk <strong>{{ $tenant->name }}</strong> belum tersedia.</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Iklim --}}
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col transition-shadow duration-300 hover:shadow-xl animated-fade">
                    <h3 class="text-xl font-bold text-[#1E4E7C] mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-[#1E4E7C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                        Iklim
                    </h3>
                    <div class="text-gray-600 prose max-w-none flex-grow">
                        {!! $tenant->iklim ?: '<p>Informasi iklim untuk wilayah ini belum tersedia.</p>' !!}
                    </div>
                </div>

                {{-- Demografi --}}
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col transition-shadow duration-300 hover:shadow-xl animated-fade">
                    <h3 class="text-xl font-bold text-[#1E4E7C] mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-[#1E4E7C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Demografi
                    </h3>
                    <div class="text-gray-600 prose max-w-none flex-grow">
                        {!! $tenant->demografi ?: '<p>Informasi demografi untuk wilayah ini belum tersedia.</p>' !!}
                    </div>
                </div>

                {{-- Topografi --}}
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col transition-shadow duration-300 hover:shadow-xl animated-fade">
                    <h3 class="text-xl font-bold text-[#1E4E7C] mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-[#1E4E7C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" /></svg>
                        Topografi
                    </h3>
                    <div class="text-gray-600 prose max-w-none flex-grow">
                        {!! $tenant->topografi ?: '<p>Informasi topografi untuk wilayah ini belum tersedia.</p>' !!}
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white p-12 rounded-lg shadow-md text-center text-gray-500 animated-fade">
                <p>Informasi Profil Wilayah belum tersedia.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.animated-fade');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        items.forEach((item, index) => { item.style.transitionDelay = `${index * 0.2}s`; observer.observe(item); });
    });
</script>
@endpush
