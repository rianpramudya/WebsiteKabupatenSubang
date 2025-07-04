@extends('layouts.app')

@section('title', 'Profil Wilayah - ' . $nama_wilayah)

@push('styles')
<style>
    .animated-fade {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
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

        {{-- Judul Halaman --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-l-8 border-green-500 animated-fade">
            <p class="text-sm uppercase text-gray-500 tracking-wider">Profil</p>
            <h1 class="text-3xl font-bold text-gray-800">Wilayah {{ $nama_wilayah }}</h1>
        </div>

        {{-- PETA WILAYAH --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 animated-fade">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Peta Wilayah
            </h2>
            <div class="rounded-lg overflow-hidden aspect-w-16 aspect-h-9 bg-gray-200">
                @php
                    $peta = isset($kecamatan) ? $kecamatan->peta_url : ($peta_url ?? null);
                @endphp

                @if (!empty($peta))
                    <iframe
                        src="{{ $peta }}"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                @else
                    <div class="flex items-center justify-center h-full text-gray-500 text-center p-4 bg-gray-100">
                        <p>Peta wilayah untuk <strong>{{ $nama_wilayah }}</strong> belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- GRID INFORMASI --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Iklim --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col transition-shadow duration-300 hover:shadow-xl animated-fade">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                    </svg>
                    Iklim
                </h3>
                <div class="text-gray-600 prose max-w-none flex-grow">
                    <p>{!! $iklim ?? 'Informasi iklim untuk wilayah ini belum tersedia.' !!}</p>
                </div>
            </div>

            {{-- Demografi --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col transition-shadow duration-300 hover:shadow-xl animated-fade">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Demografi
                </h3>
                <div class="text-gray-600 prose max-w-none flex-grow">
                    <p>{!! $demografi ?? 'Informasi demografi untuk wilayah ini belum tersedia.' !!}</p>
                </div>
            </div>

            {{-- Topografi --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col transition-shadow duration-300 hover:shadow-xl animated-fade">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                    </svg>
                    Topografi
                </h3>
                <div class="text-gray-600 prose max-w-none flex-grow">
                    <details class="group">
                        <summary class="font-semibold cursor-pointer hover:text-green-700 list-none flex justify-between items-center">
                            <span>Klik untuk melihat detail</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="mt-4 border-t pt-4">
                            <p>{!! $topografi ?? 'Informasi topografi untuk wilayah ini belum tersedia.' !!}</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.animated-fade');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    items.forEach((item, index) => {
        item.style.transitionDelay = `${index * 0.2}s`;
        observer.observe(item);
    });
});
</script>
@endpush
