@extends('layouts.app')

@php
    $namaKonteks = 'Kabupaten Subang'; // Default
    if (isset($currentPerangkatDaerah)) {
        $namaKonteks = $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan) && $currentKecamatan->slug !== 'kabupaten-subang') {
        $namaKonteks = 'Kecamatan ' . $currentKecamatan->name;
    }
@endphp

@section('title', 'Penghargaan - ' . $namaKonteks)

@push('styles')
<style>
    .animated-item { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
    .animated-item.is-visible { opacity: 1; transform: translateY(0); }
    .timeline-container::before { content: ''; position: absolute; left: 50%; transform: translateX(-50%); top: 0; bottom: 0; width: 4px; background-color: #e2e8f0; border-radius: 2px; }
    .timeline-item { position: relative; width: 50%; padding: 20px 40px; box-sizing: border-box; }
    .timeline-item:nth-child(odd) { left: 0; }
    .timeline-item:nth-child(even) { left: 50%; }
    .timeline-item::after {
        content: ''; position: absolute; width: 24px; height: 24px; right: -12px;
        background-color: white; border: 4px solid #1E4E7C;
        top: 35px; border-radius: 50%; z-index: 1;
    }
    .timeline-item:nth-child(even)::after { left: -12px; }
    @media screen and (max-width: 768px) {
        .timeline-container::before { left: 12px; }
        .timeline-item { width: 100%; padding-left: 70px; padding-right: 25px; }
        .timeline-item:nth-child(odd), .timeline-item:nth-child(even) { left: 0; }
        .timeline-item::after { left: 0; }
    }
</style>
@endpush

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 animated-item">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E4E7C] tracking-tight">
                Galeri Penghargaan
            </h1>

            <p class="mt-3 text-xl text-gray-500">
                {{ $namaKonteks }}
            </p>
        </div>

        @if($penghargaan_per_tahun->isEmpty())
            <div class="text-center text-gray-500 py-16 bg-white rounded-lg shadow-lg animated-item">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum Ada Data</h3>
                <p class="mt-1 text-sm text-gray-500">Saat ini belum ada data penghargaan yang dapat ditampilkan.</p>
            </div>
        @else
            <div class="relative timeline-container">
                @foreach($penghargaan_per_tahun as $tahun => $penghargaans)
                    @foreach($penghargaans as $penghargaan)
                        <div class="timeline-item animated-item">
                            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-shadow duration-300 border-l-4 border-[#1E4E7C]">
                                <span class="text-sm font-semibold text-[#1E4E7C] bg-[#FCE405] py-1 px-3 rounded-full">{{ $tahun }}</span>
                                <h3 class="font-bold text-gray-800 text-xl mt-3 mb-2">{{ $penghargaan->nama_penghargaan }}</h3>
                                <div class="space-y-3 text-gray-600">
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#1E4E7C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        <span class="font-semibold mr-2">Tingkat:</span> {{ $penghargaan->tingkat }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-[#1E4E7C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="font-semibold mr-2">Pemberi:</span> {{ $penghargaan->instansi_pemberi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => { entry.target.classList.add('is-visible'); }, index * 150);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    items.forEach(item => { observer.observe(item); });
});
</script>
@endpush
