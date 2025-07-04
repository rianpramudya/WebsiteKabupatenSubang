@extends('layouts.app')

@section('title', 'Struktur Pemerintahan - ' . $nama_wilayah)

@push('styles')
<style>
    /* Styling untuk garis-garis pada bagan organisasi */
    .org-chart-node {
        position: relative;
        padding-top: 2.5rem; /* Memberi ruang untuk garis dari atas */
    }
    .org-chart-node::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        background-color: #cbd5e1; /* gray-300 */
        top: 0;
        width: 2px;
        height: 2.5rem; /* Tinggi garis vertikal */
    }
    /* Garis horizontal */
    .org-chart-group {
        position: relative;
        padding-top: 2.5rem; /* Ruang untuk garis horizontal di atas */
    }
    .org-chart-group::before {
        content: '';
        position: absolute;
        top: 0;
        left: 25%;
        right: 25%;
        height: 2px;
        background-color: #cbd5e1; /* gray-300 */
    }
    /* Sembunyikan garis horizontal jika hanya ada 1 item */
    .org-chart-group[data-count="1"]::before {
        display: none;
    }
    /* Sembunyikan garis vertikal untuk item di level teratas */
    .top-level-node {
        padding-top: 0;
    }
    .top-level-node::before {
        display: none;
    }

    /* === ANIMASI === */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
        animation-delay: var(--row-delay, 0ms);
    }
    .fade-in-left {
        opacity: 0;
        animation: fadeInLeft 0.7s ease-out forwards;
        animation-delay: var(--row-delay, 0ms);
    }
    .fade-in-right {
        opacity: 0;
        animation: fadeInRight 0.7s ease-out forwards;
        animation-delay: var(--row-delay, 0ms);
    }
</style>
@endpush

@section('content')

<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 sm:px-6">

        {{-- Judul Halaman --}}
        <div class="text-center mb-12 fade-in-up" style="--row-delay: 100ms;">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Struktur Pemerintahan</h1>
            <p class="mt-2 text-xl text-gray-500">{{ $nama_wilayah }}</p>
        </div>

        {{-- Kontainer Bagan --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 fade-in-up" style="--row-delay: 250ms;">
            @if($semua_pejabat->isEmpty())
                <div class="text-center text-gray-500 py-10">
                    <p>Struktur pemerintahan untuk wilayah ini belum tersedia.</p>
                </div>
            @else
                @php
                    $pimpinan = $semua_pejabat->first(fn($p) => str_contains($p->jabatan, 'Bupati') || str_contains($p->jabatan, 'Camat'));
                    $pejabatSisa = $pimpinan ? $semua_pejabat->where('id', '!=', $pimpinan->id) : $semua_pejabat;
                    $wakil_pimpinan = $pejabatSisa->first(fn($p) => str_contains($p->jabatan, 'Sekretaris'));
                    $pejabatSisa = $wakil_pimpinan ? $pejabatSisa->where('id', '!=', $wakil_pimpinan->id) : $pejabatSisa;
                    $kepala_bagian = $pejabatSisa->filter(fn($p) => str_starts_with($p->jabatan, 'Kasi') || str_starts_with($p->jabatan, 'Kasubag') || str_starts_with($p->jabatan, 'Kepala'));
                    $idKepalaBagian = $kepala_bagian->pluck('id');
                    $staf = $pejabatSisa->whereNotIn('id', $idKepalaBagian);
                    
                    // Counter untuk delay animasi
                    $delayCounter = 300;
                @endphp

                <div class="flex flex-col items-center space-y-8">
                    
                    @if($pimpinan)
                    <div class="top-level-node fade-in-up" style="--row-delay: {{ $delayCounter }}ms;">
                        <div class="text-center w-48">
                            <img src="{{ asset('storage/' . $pimpinan->foto_url) }}" alt="Foto {{ $pimpinan->nama }}" class="w-24 h-24 rounded-full mx-auto shadow-lg border-4 border-white object-cover" onerror="this.onerror=null; this.src='https://placehold.co/100x100/E2E8F0/4A5568?text=Foto';">
                            <h3 class="mt-3 font-bold text-md text-gray-800">{{ $pimpinan->nama }}</h3>
                            <p class="text-xs text-gray-500">{{ $pimpinan->jabatan }}</p>
                        </div>
                    </div>
                    @php $delayCounter += 150; @endphp
                    @endif

                    @if($pimpinan && ($wakil_pimpinan || $kepala_bagian->isNotEmpty()))
                    <div class="w-px h-8 bg-gray-300 fade-in-up" style="--row-delay: {{ $delayCounter }}ms;"></div>
                    @endif

                    @if($wakil_pimpinan)
                    <div class="top-level-node fade-in-up" style="--row-delay: {{ $delayCounter }}ms;">
                         <div class="text-center w-48">
                            <img src="{{ asset('storage/' . $wakil_pimpinan->foto_url) }}" alt="Foto {{ $wakil_pimpinan->nama }}" class="w-24 h-24 rounded-full mx-auto shadow-lg border-4 border-white object-cover" onerror="this.onerror=null; this.src='https://placehold.co/100x100/E2E8F0/4A5568?text=Foto';">
                            <h3 class="mt-3 font-bold text-md text-gray-800">{{ $wakil_pimpinan->nama }}</h3>
                            <p class="text-xs text-gray-500">{{ $wakil_pimpinan->jabatan }}</p>
                        </div>
                    </div>
                    @php $delayCounter += 150; @endphp
                    @endif
                    
                    @if($wakil_pimpinan && $kepala_bagian->isNotEmpty())
                    <div class="w-px h-8 bg-gray-300 fade-in-up" style="--row-delay: {{ $delayCounter }}ms;"></div>
                    @endif

                    @if($kepala_bagian->isNotEmpty())
                    <div class="w-full org-chart-group" data-count="{{ $kepala_bagian->count() }}">
                        <div class="flex justify-center flex-wrap gap-x-8 gap-y-4">
                            @foreach($kepala_bagian as $pejabat)
                            @php 
                                $anim = $loop->even ? 'fade-in-right' : 'fade-in-left'; 
                                $delayCounter += 100;
                            @endphp
                            <div class="flex-shrink-0 org-chart-node {{ $anim }}" style="--row-delay: {{ $delayCounter }}ms;">
                                <div class="text-center w-48">
                                    <img src="{{ asset('storage/' . $pejabat->foto_url) }}" alt="Foto {{ $pejabat->nama }}" class="w-24 h-24 rounded-full mx-auto shadow-lg border-4 border-white object-cover" onerror="this.onerror=null; this.src='https://placehold.co/100x100/E2E8F0/4A5568?text=Foto';">
                                    <h3 class="mt-3 font-bold text-md text-gray-800">{{ $pejabat->nama }}</h3>
                                    <p class="text-xs text-gray-500">{{ $pejabat->jabatan }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @php $delayCounter += 150; @endphp
                    @endif
                    
                    @if($kepala_bagian->isNotEmpty() && $staf->isNotEmpty())
                    <div class="w-px h-8 bg-gray-300 fade-in-up" style="--row-delay: {{ $delayCounter }}ms;"></div>
                    @endif

                    @if($staf->isNotEmpty())
                     <div class="w-full org-chart-group" data-count="{{ $staf->count() }}">
                        <div class="flex justify-center flex-wrap gap-x-8 gap-y-4">
                             @foreach($staf as $pejabat)
                             @php 
                                $anim = $loop->even ? 'fade-in-right' : 'fade-in-left'; 
                                $delayCounter += 100;
                            @endphp
                            <div class="flex-shrink-0 org-chart-node {{ $anim }}" style="--row-delay: {{ $delayCounter }}ms;">
                                <div class="text-center w-48">
                                    <img src="{{ asset('storage/' . $pejabat->foto_url) }}" alt="Foto {{ $pejabat->nama }}" class="w-24 h-24 rounded-full mx-auto shadow-lg border-4 border-white object-cover" onerror="this.onerror=null; this.src='https://placehold.co/100x100/E2E8F0/4A5568?text=Foto';">
                                    <h3 class="mt-3 font-bold text-md text-gray-800">{{ $pejabat->nama }}</h3>
                                    <p class="text-xs text-gray-500">{{ $pejabat->jabatan }}</p>
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
</div>

@endsection