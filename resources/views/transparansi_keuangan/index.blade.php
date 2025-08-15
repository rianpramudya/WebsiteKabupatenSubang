@extends('layouts.app')

{{-- 1. Blok PHP untuk judul dinamis --}}
@php
$namaKonteks = 'Kabupaten Subang'; // Default
if (isset($currentPerangkatDaerah)) {
$namaKonteks = $currentPerangkatDaerah->name;
} elseif (isset($currentKecamatan)) {
$namaKonteks = 'Kecamatan ' . $currentKecamatan->name;
}
@endphp

@section('title', $namaKonteks . ' - Transparansi Keuangan')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
    }

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

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 3px;
        height: 100%;
        background-color: #e2e8f0;
        z-index: 1;
    }

    .timeline-dot {
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        background-color: white;
        border: 4px solid #1E4E7C;
        border-radius: 50%;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .timeline-year-marker:hover .timeline-dot {
        transform: translateX(-50%) scale(1.2);
    }

    .timeline-item {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .timeline-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .report-card {
        width: 100%;
        max-width: 440px;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .report-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1),
            0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .report-card-content {
        flex-grow: 1;
    }

    .report-card-title {
        min-height: 56px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .link-arrow {
        transition: transform 0.3s ease;
    }

    .group:hover .link-arrow {
        transform: translateX(4px);
    }

    @media (max-width: 768px) {
        .timeline-container::before {
            left: 15px;
        }

        .timeline-dot {
            left: 15px;
        }

        .timeline-content-col {
            grid-column: span 2 / span 2;
            justify-self: start !important;
            padding-left: 35px;
        }

        .timeline-year-marker {
            justify-content: start;
            padding-left: 35px;
        }
    }
</style>
@endpush

@section('content')
<header class="relative overflow-hidden text-white shadow-lg bg-gray-900">
    <div class="absolute inset-0 z-0" style="background-image: linear-gradient(rgba(20, 20, 20, 0.6), rgba(10, 10, 10, 0.8)),
                  url('https://images.unsplash.com/photo-1599325889424-51a629447e19?w=1200&auto=format&fit=crop&q=80');
                background-size: cover;
                background-position: center;">
    </div>
    <div class="container mx-auto text-center relative z-10 py-20 px-4">
        <div class="animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2 text-[#FCE405] drop-shadow-lg">
                Transparansi Keuangan</h1>
            {{-- 2. Gunakan nama konteks dinamis --}}
            <p class="text-xl md:text-2xl font-light text-gray-200 drop-shadow-md">
                {{ $namaKonteks }}
            </p>
        </div>
    </div>
</header>

<main class="container mx-auto px-4 py-12 md:py-16">
    @if(count($laporan_per_tahun) > 0)
    <div id="year-filters" class="flex justify-center flex-wrap gap-3 mb-12 animate-fade-in-up"
        style="animation-delay: 200ms;">
        @foreach ($laporan_per_tahun as $tahun => $laporans)
        <button
            onclick="document.getElementById('year-{{ $tahun }}').scrollIntoView({behavior: 'smooth', block: 'center'})"
            class="px-5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-full hover:bg-[#1E4E7C] hover:text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#1E4E7C] focus:ring-opacity-50 transition-all duration-300">
            Tahun {{ $tahun }}
        </button>
        @endforeach
    </div>
    @endif

    <div class="relative timeline-container max-w-5xl mx-auto">
        @forelse ($laporan_per_tahun as $tahun => $laporans)
        <div id="year-{{ $tahun }}"
            class="timeline-item timeline-year-marker relative flex items-center justify-center my-8">
            <div class="timeline-dot"></div>
            <h2 class="text-2xl font-bold text-[#1E4E7C] bg-white px-6 py-2 rounded-full shadow-md z-10">{{ $tahun }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 md:auto-rows-fr">
            @foreach ($laporans as $laporan)
            <div
                class="timeline-content-col @if($loop->iteration % 2 == 1) md:justify-self-end @else md:justify-self-start @endif flex">
                <div class="timeline-item report-card bg-white rounded-xl shadow-md border border-slate-100 w-full">
                    <div class="report-card-content p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-[#1E4E7C]/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#1E4E7C]" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m-1.5 0L3.75 7.5M8.25 4.5l3.75-3.75M8.25 4.5v15m0-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h3 class="report-card-title text-lg font-semibold text-slate-800">{{
                                    $laporan->judul_laporan }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{
                                    \Carbon\Carbon::parse($laporan->created_at)->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 rounded-b-xl">
                        <a href="{{ asset('storage/' . $laporan->file_url) }}" target="_blank"
                            class="group text-sm text-[#1E4E7C] hover:brightness-90 font-semibold inline-flex items-center transition-colors duration-300">
                            Lihat Dokumen
                            <svg class="ml-2 w-4 h-4 link-arrow" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @empty
        <div class="text-center py-20">
            <div class="flex flex-col items-center justify-center space-y-4">
                <svg class="w-20 h-20 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m-1.5 0L3.75 7.5M8.25 4.5l3.75-3.75M8.25 4.5v15m0-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p class="text-slate-500 text-xl font-medium">Belum Ada Data Laporan</p>
                <p class="text-slate-400 max-w-md">Saat ini belum ada data laporan keuangan yang dipublikasikan. Silakan
                    periksa kembali nanti.</p>
            </div>
        </div>
        @endforelse
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.timeline-item').forEach(item => {
            observer.observe(item);
        });
    });
</script>
@endpush