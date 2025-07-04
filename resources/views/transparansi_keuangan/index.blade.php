@extends('layouts.app')

@section('title', $nama_wilayah . ' - Transparansi Keuangan')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
        /* Latar belakang halaman yang sedikit abu-abu */
    }

    /* === ANIMASI === */
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

    /* === TIMELINE === */
    .timeline-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 3px;
        height: 100%;
        background-color: #e2e8f0;
        /* slate-200 */
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
        border: 4px solid #10B981;
        /* emerald-500 */
        border-radius: 50%;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .timeline-year-marker:hover .timeline-dot {
        transform: translateX(-50%) scale(1.2);
    }

    /* Animasi untuk item yang muncul saat scroll */
    .timeline-item {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .timeline-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* === KARTU LAPORAN DENGAN UKURAN PASTI (DIPERBAIKI) === */
    .report-card {
        /* Ukuran kartu dibuat pasti. Sesuaikan nilai ini jika perlu. */
        width: 100%; 
        max-width: 440px; /* Lebar maksimum kartu */
        height: 180px; /* Tinggi kartu dibuat tetap untuk semua kartu */
        
        display: flex;
        flex-direction: column; /* Konten diatur vertikal */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .report-card-content {
        flex-grow: 1; /* Area konten akan mengisi sisa ruang, mendorong footer ke bawah */
    }
    .report-card-title {
        /* Membatasi judul hanya 2 baris untuk menjaga layout */
        height: 56px; /* Sesuaikan tinggi ini (ukuran font * line-height * 2 baris) */
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .report-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }


    .link-arrow {
        transition: transform 0.3s ease;
    }

    .group:hover .link-arrow {
        transform: translateX(4px);
    }

    /* Penyesuaian untuk mobile */
    @media (max-width: 768px) {
        .timeline-container::before {
            left: 15px;
            /* Geser garis ke kiri */
        }

        .timeline-dot {
            left: 15px;
        }

        .timeline-content-col {
            grid-column: span 2 / span 2;
            /* Buat jadi 1 kolom */
            justify-self: start !important; /* Semua kartu mulai dari kiri di mobile */
            padding-left: 35px;
            /* Beri jarak dari garis */
        }

        .timeline-year-marker {
            justify-content: start;
            padding-left: 35px;
        }
    }
</style>
@endpush

@section('content')
<!-- ***** HEADER ***** -->
<header class="relative overflow-hidden text-white shadow-lg bg-gray-900">
    <!-- Elemen untuk Latar Belakang dan Overlay -->
    <div class="absolute inset-0 z-0"
        style="background-image: 
                linear-gradient(rgba(20, 20, 20, 0.6), rgba(10, 10, 10, 0.8)), 
                url('https://images.unsplash.com/photo-1599325889424-51a629447e19?w=1200&auto=format&fit=crop&q=80'); 
                background-size: cover; 
                background-position: center;">
    </div>

    <!-- Konten Header -->
    <div class="container mx-auto text-center relative z-10 py-20 px-4">
        <div class="animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2 text-white drop-shadow-lg">Transparansi Keuangan</h1>
            <p class="text-xl md:text-2xl font-light text-gray-200 drop-shadow-md">{{ $nama_wilayah }}</p>
        </div>
    </div>
</header>


<main class="container mx-auto px-4 py-12 md:py-16">
    <!-- Filter Tahun -->
    @if(count($laporan_per_tahun) > 0)
    <div id="year-filters" class="flex justify-center flex-wrap gap-3 mb-12 animate-fade-in-up" style="animation-delay: 200ms;">
        @foreach ($laporan_per_tahun as $tahun => $laporans)
        <button onclick="document.getElementById('year-{{ $tahun }}').scrollIntoView({behavior: 'smooth', block: 'center'})"
            class="px-5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 rounded-full hover:bg-emerald-500 hover:text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-opacity-50 transition-all duration-300">
            Tahun {{ $tahun }}
        </button>
        @endforeach
    </div>
    @endif

    <!-- Timeline Container -->
    <div class="relative timeline-container max-w-5xl mx-auto">
        @forelse ($laporan_per_tahun as $tahun => $laporans)
        <!-- Penanda Tahun -->
        <div id="year-{{ $tahun }}" class="timeline-item timeline-year-marker relative flex items-center justify-center my-8">
            <div class="timeline-dot"></div>
            <h2 class="text-2xl font-bold text-emerald-600 bg-white px-6 py-2 rounded-full shadow-md z-10">{{ $tahun }}</h2>
        </div>

        <!-- Grid untuk Kartu Laporan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            @foreach ($laporans as $laporan)
            <!-- Wrapper untuk mengatur posisi kartu di kiri/kanan. Logika justify-self diperbaiki -->
            <div class="timeline-content-col @if($loop->iteration % 2 == 1) md:justify-self-end @else md:justify-self-start @endif">
                <div class="timeline-item report-card bg-white rounded-xl shadow-md border border-slate-100">
                    <div class="report-card-content p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m-1.5 0L3.75 7.5M8.25 4.5l3.75-3.75M8.25 4.5v15m0-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h3 class="report-card-title text-lg font-semibold text-slate-800">{{ $laporan->judul_laporan }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 rounded-b-xl">
                        <a href="{{ $laporan->file_url }}" target="_blank"
                            class="group text-sm text-emerald-600 hover:text-emerald-800 font-semibold inline-flex items-center transition-colors duration-300">
                            Lihat Dokumen
                            <svg class="ml-2 w-4 h-4 link-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
                <svg class="w-20 h-20 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m-1.5 0L3.75 7.5M8.25 4.5l3.75-3.75M8.25 4.5v15m0-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p class="text-slate-500 text-xl font-medium">Belum Ada Data Laporan</p>
                <p class="text-slate-400 max-w-md">Saat ini belum ada data laporan keuangan yang dipublikasikan. Silakan periksa kembali nanti.</p>
            </div>
        </div>
        @endforelse
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Intersection Observer untuk animasi saat scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // Opsional: berhenti mengamati setelah animasi berjalan
                    // observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1 // Animasi berjalan saat 10% elemen terlihat
        });

        // Amati semua elemen dengan kelas .timeline-item
        document.querySelectorAll('.timeline-item').forEach(item => {
            observer.observe(item);
        });
    });
</script>
@endpush
