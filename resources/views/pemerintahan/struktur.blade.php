@extends('layouts.app')

@php
$namaKonteks = 'Kabupaten Subang'; // Default
if (isset($currentPerangkatDaerah)) {
$namaKonteks = $currentPerangkatDaerah->name;
} elseif (isset($currentKecamatan)) {
$namaKonteks = 'Kecamatan ' . $currentKecamatan->name;
}
@endphp

@section('title', 'Struktur Organisasi - ' . $namaKonteks)
@push('styles')
<style>
    :root {
        --org-line-color: #d1d5db;

        --org-card-bg: #ffffff;
        --org-card-border: #1E4E7C;

        --org-text-title: #1f2937;

        --org-text-body: #4b5563;

        --org-gap: 50px;

    }

    .org-chart {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .org-chart ul {
        display: flex;
        justify-content: center;
        list-style-type: none;
        padding: 0;
        position: relative;
        margin-top: var(--org-gap);
    }

    .org-chart>ul:first-child {
        margin-top: 0;
    }

    .org-chart li {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 1.5rem;

        position: relative;
    }

    .org-chart li::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: calc(var(--org-gap) / 2);
        background-color: var(--org-line-color);
    }

    .org-chart li::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: calc(var(--org-gap) / 2);
        background-color: var(--org-line-color);
    }

    .org-chart li:not(:only-child)::after {

        display: none;
    }

    .org-chart ul::after {
        content: '';
        position: absolute;
        top: calc(0px - var(--org-gap) / 2);
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: calc(var(--org-gap) / 2);
        background-color: var(--org-line-color);
    }

    .org-chart ul:not(:has(li:only-child))::before {
        content: '';
        position: absolute;
        top: calc(0px - var(--org-gap) / 2);
        left: 15%;

        right: 15%;

        height: 2px;
        background-color: var(--org-line-color);
    }

    .org-chart>ul:first-child>li::before {
        display: none;
    }

    .org-chart>ul:last-child>li::after {
        display: none;
    }

    .org-chart>ul:first-child::after {
        display: none;
    }

    .org-card {
        background-color: var(--org-card-bg);
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        text-align: center;
        width: 280px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 5px solid var(--org-card-border);
        z-index: 1;

    }

    .org-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }

    .org-card .foto-pejabat {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1rem auto;
        border: 5px solid #f3f4f6;
    }

    .org-card .nama {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--org-text-title);
    }

    .org-card .jabatan {
        font-size: 0.875rem;
        color: var(--org-text-body);
        margin-top: 0.25rem;
    }

    .animated-item {
        opacity: 0;
        transform: scale(0.95) translateY(20px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }

    .animated-item.is-visible {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-100 min-h-screen py-20">
    <div class="container mx-auto px-4 sm:px-6 overflow-x-auto">

        <div class="text-center mb-16 animated-item">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E4E7C] tracking-tight">
                Struktur Organisasi
            </h1>

            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                {{ $namaKonteks }}
            </p>
        </div>

        @if($semua_pejabat->isEmpty())
        <div class="text-center text-gray-500 py-20 bg-white/70 backdrop-blur-sm rounded-lg shadow-lg animated-item">
            <p class="text-lg">Struktur pemerintahan untuk wilayah ini belum tersedia.</p>
        </div>
        @else
        @php
        $groupedPejabats = $semua_pejabat->sortBy('urutan')->groupBy('urutan');
        @endphp

        <div class="org-chart">
            @foreach($groupedPejabats as $urutan => $pejabatsDiLevelIni)
            <ul class="animated-item">
                @foreach($pejabatsDiLevelIni as $pejabat)
                <li>
                    <div class="org-card">
                        <img src="{{ $pejabat->foto_url }}" alt="Foto {{ $pejabat->nama }}" class="foto-pejabat"
                            onerror="this.onerror=null; this.src='https://placehold.co/100x100/e2e8f0/4A5568?text=Foto';">
                        <h4 class="nama">{{ $pejabat->nama }}</h4>
                        <p class="jabatan">{{ $pejabat->jabatan }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @endforeach
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