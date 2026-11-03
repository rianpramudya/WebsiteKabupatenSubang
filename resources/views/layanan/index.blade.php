@extends('layouts.app')

@php
    $judulHalaman = 'Layanan Publik';
    $subJudul = 'Semua layanan publik yang tersedia.'; // Default
    $kembaliUrl = route('home'); // Default

    if (isset($currentPerangkatDaerah)) {
        $judulHalaman = 'Layanan Publik ' . $currentPerangkatDaerah->name;
        $subJudul = 'Semua layanan publik yang tersedia di ' . $currentPerangkatDaerah->name;
        $kembaliUrl = route('perangkat.show', $currentPerangkatDaerah->slug);
    } elseif (isset($currentKecamatan)) {
        $judulHalaman = 'Layanan Publik Kecamatan ' . $currentKecamatan->name;
        $subJudul = 'Semua layanan publik yang tersedia di Kecamatan ' . $currentKecamatan->name;
        $kembaliUrl = route('kecamatan.show', $currentKecamatan->slug);
    }
@endphp

@section('title', $judulHalaman)

@push('styles')
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(10px); }
        }
        #page-content {
            animation: fadeIn 0.5s ease-out forwards;
        }
        body.fading-out #page-content {
            animation: fadeOut 0.5s ease-out forwards;
        }
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-height: 1.5;
            max-height: calc(1.5em * 2);
            word-break: break-all;
        }
    </style>
@endpush

@section('content')
<div id="page-content">
    <div class="bg-gray-50 py-12 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6">

            <div class="text-center mb-10">

                <h1 class="text-3xl md:text-4xl font-extrabold text-[#1E4E7C]">{{ $judulHalaman }}</h1>
                <p class="mt-2 text-lg text-gray-600">{{ $subJudul }}</p>
            </div>

            @if ($layanans->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($layanans as $layanan)
                        <div
                            class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-transform duration-300">
                            <div
                                class="bg-[#1E4E7C]/10 text-[#1E4E7C] w-20 h-20 rounded-full flex items-center justify-center mb-4">
                                <i class="{{ $layanan->icon ?? 'fas fa-concierge-bell' }} text-4xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $layanan->nama }}</h4>

                            <p class="text-gray-600 text-sm mb-6 flex-grow line-clamp-2">
                                {{ strip_tags(html_entity_decode($layanan->deskripsi)) ?? 'Informasi lebih lanjut tersedia di link berikut.' }}
                            </p>

                            @php
                                $detailUrl = '#';
                                if (isset($currentPerangkatDaerah)) {
                                    $detailUrl = route('perangkat.layanan.detail', ['perangkatDaerah' => $currentPerangkatDaerah->slug, 'layanan' => $layanan]);
                                } elseif (isset($currentKecamatan)) {
                                    $detailUrl = route('layanan.detail', ['kecamatan' => $currentKecamatan->slug, 'layanan' => $layanan]);
                                }
                            @endphp
                            <a href="{{ $detailUrl }}"
                                class="mt-auto inline-block bg-[#1E4E7C] text-white font-bold py-2 px-6 rounded-lg hover:brightness-90 transition-all duration-300 w-full">
                                Lihat Detail
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>

                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $layanans->links() }}
                </div>

            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500 mt-12">
                    <i class="fas fa-info-circle text-4xl mb-4"></i>
                    <p>Belum ada layanan yang terdaftar untuk saat ini.</p>
                </div>
            @endif

            <div class="text-center mt-12">

                <a href="{{ $kembaliUrl }}" class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                    <span class="group-hover:-translate-x-1 inline-block transition-transform">&larr;</span>
                    @if(isset($currentPerangkatDaerah))
                        Kembali ke Halaman {{ $currentPerangkatDaerah->name }}
                    @elseif(isset($currentKecamatan))
                        Kembali ke Halaman Kecamatan
                    @else
                        Kembali ke Beranda
                    @endif
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fadeOutDuration = 500;
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(.pagination a)');

            links.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    document.body.classList.add('fading-out');
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, fadeOutDuration);
                });
            });

            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    document.body.classList.remove('fading-out');
                }
            });
        });
    </script>
@endpush
