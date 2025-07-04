@extends('layouts.app')

@section('title', 'Struktur Pemerintahan - ' . $nama_wilayah)

@push('styles')
<style>
    /* Background gradien animasi */
    .dynamic-bg {
        background: linear-gradient(-45deg, #f0f9ff, #e0f2fe, #f0f9ff, #fafafa);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Kartu Pimpinan */
    .org-card-leader {
        background-color: white;
        border-radius: 0.75rem; /* 12px */
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        transition: transform 0.3s ease, box-shadow 0.4s ease;
        border-left: 6px solid #0ea5e9; /* sky-500 */
        overflow: hidden;
    }
    .org-card-leader:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1), 0 0 0 4px rgb(14 165 233 / 0.2);
    }
    .org-card-leader .foto-pejabat {
        transition: transform 0.3s ease;
    }
    .org-card-leader:hover .foto-pejabat {
        transform: scale(1.05);
    }

    /* Kartu Anggota */
    .org-card-member {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        border-top: 4px solid #e5e7eb; /* gray-200 */
        text-align: center;
        padding: 1.5rem; /* 24px */
    }
    .org-card-member:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        border-top-color: #3b82f6; /* blue-500 */
    }
    .org-card-member .foto-pejabat {
         transition: transform 0.3s ease;
    }
    .org-card-member:hover .foto-pejabat {
        transform: scale(1.1);
    }

    /* Garis Penghubung */
    .connector-line {
        width: 2px;
        background: linear-gradient(to bottom, #d1d5db, #e5e7eb);
        margin: 0 auto;
    }
    .horizontal-connector {
        width: 90%;
        max-width: 1200px;
        height: 2px;
        background: linear-gradient(to right, #e5e7eb, #d1d5db, #e5e7eb);
        margin: 0 auto;
    }

    /* Animasi saat item muncul */
    .animated-item {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .animated-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

<div class="dynamic-bg min-h-screen py-20">
    <div class="container mx-auto px-4 sm:px-6">

        {{-- Judul Halaman --}}
        <div class="text-center mb-20 animated-item">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                Struktur Organisasi
            </h1>
            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">{{ $nama_wilayah }}</p>
        </div>

        @if($semua_pejabat->isEmpty())
            <div class="text-center text-gray-500 py-20 bg-white/70 backdrop-blur-sm rounded-lg shadow-lg animated-item">
                <p class="text-lg">Struktur pemerintahan untuk wilayah ini belum tersedia.</p>
            </div>
        @else
            @php
                // Logika untuk memisahkan pejabat
                $pimpinan = $semua_pejabat->sortBy('urutan')->first(fn($p) => str_contains(strtolower($p->jabatan), 'bupati') || str_contains(strtolower($p->jabatan), 'camat'));
                $pejabatSisa = $pimpinan ? $semua_pejabat->where('id', '!=', $pimpinan->id) : $semua_pejabat;
                
                $wakil_pimpinan = $pejabatSisa->sortBy('urutan')->first(fn($p) => str_contains(strtolower($p->jabatan), 'sekretaris'));
                $pejabatSisa = $wakil_pimpinan ? $pejabatSisa->where('id', '!=', $wakil_pimpinan->id) : $pejabatSisa;

                $pejabatStruktural = $pejabatSisa->sortBy('urutan');
            @endphp

            <div class="flex flex-col items-center space-y-10">
                
                <!-- Pimpinan -->
                @if($pimpinan)
                <div class="w-full max-w-lg animated-item">
                    <div class="org-card-leader p-6 flex items-center space-x-6">
                        <img src="{{ $pimpinan->foto_url }}" alt="Foto {{ $pimpinan->nama }}" class="foto-pejabat w-28 h-28 rounded-full object-cover flex-shrink-0 border-4 border-white shadow-md" onerror="this.onerror=null; this.src='https://placehold.co/112x112/E2E8F0/4A5568?text=Foto';">
                        <div class="flex-grow">
                            <h3 class="font-bold text-2xl text-gray-900">{{ $pimpinan->nama }}</h3>
                            <p class="text-lg text-sky-700 font-semibold">{{ $pimpinan->jabatan }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Garis Penghubung -->
                @if($pimpinan && ($wakil_pimpinan || $pejabatStruktural->isNotEmpty()))
                    <div class="connector-line h-10 animated-item"></div>
                @endif

                <!-- Wakil Pimpinan -->
                @if($wakil_pimpinan)
                <div class="w-full max-w-lg animated-item">
                     <div class="org-card-leader p-6 flex items-center space-x-6">
                        <img src="{{ $wakil_pimpinan->foto_url }}" alt="Foto {{ $wakil_pimpinan->nama }}" class="foto-pejabat w-28 h-28 rounded-full object-cover flex-shrink-0 border-4 border-white shadow-md" onerror="this.onerror=null; this.src='https://placehold.co/112x112/E2E8F0/4A5568?text=Foto';">
                        <div class="flex-grow">
                            <h3 class="font-bold text-2xl text-gray-900">{{ $wakil_pimpinan->nama }}</h3>
                            <p class="text-lg text-gray-600 font-semibold">{{ $wakil_pimpinan->jabatan }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Garis Penghubung ke Staf -->
                @if($wakil_pimpinan && $pejabatStruktural->isNotEmpty())
                    <div class="connector-line h-10 animated-item"></div>
                    <div class="horizontal-connector animated-item"></div>
                    <div class="connector-line h-10 animated-item"></div>
                @endif

                <!-- Pejabat Struktural Lainnya -->
                @if($pejabatStruktural->isNotEmpty())
                <div class="w-full">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                        @foreach($pejabatStruktural as $pejabat)
                        <div class="animated-item">
                            <div class="org-card-member h-full">
                                <img src="{{ $pejabat->foto_url }}" alt="Foto {{ $pejabat->nama }}" class="foto-pejabat w-24 h-24 rounded-full mx-auto object-cover mb-4 border-4 border-white shadow-md" onerror="this.onerror=null; this.src='https://placehold.co/96x96/E2E8F0/4A5568?text=Foto';">
                                <h4 class="font-bold text-lg text-gray-800">{{ $pejabat->nama }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $pejabat->jabatan }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.animated-item');

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
        item.style.transitionDelay = `${index * 150}ms`;
        observer.observe(item);
    });
});
</script>
@endpush
