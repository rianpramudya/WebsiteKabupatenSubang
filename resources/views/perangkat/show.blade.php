@extends('layouts.app')

@section('title', $currentPerangkatDaerah->name . ' - Portal Kabupaten Subang')

@push('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

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

    .anim-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.7s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim-fade-in-down {
        opacity: 0;
        animation: fadeInDown 0.7s ease-out forwards;
        animation-delay: var(--anim-delay, 0ms);
    }

    .hero-news-slider .swiper-slide a {
        position: relative;
        display: block;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        border-radius: 1rem;
        overflow: hidden;
        color: white;
    }

    .hero-news-slider .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent 60%);
    }

    .hero-news-slider .slide-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        z-index: 10;
    }

    .hero-news-slider .slide-content h3 {
        font-size: 1.25rem;
        font-weight: 800;
        line-height: 1.2;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
    }

    @media (min-width: 768px) {
        .hero-news-slider .slide-content h3 {
            font-size: 1.75rem;
        }
    }

    .hero-news-slider .slide-content p {
        font-size: 0.9rem;
        margin-top: 0.5rem;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        opacity: 0.9;
    }

    .hero-news-slider .swiper-button-next,
    .hero-news-slider .swiper-button-prev {
        color: white;
    }

    .hero-news-slider .swiper-button-next::after,
    .hero-news-slider .swiper-button-prev::after {
        font-size: 24px;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
    }

    .video-gallery-slider,
    .photo-gallery-slider {
        width: 100%;
        height: 100%;
        border-radius: 1rem;
        overflow: hidden;
    }

    .photo-gallery-slider .swiper-slide {
        width: 100%;
        height: 100%;
    }

    .video-gallery-slider .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
        background: white;
    }

    .video-gallery-slider .swiper-button-next,
    .video-gallery-slider .swiper-button-prev,
    .photo-gallery-slider .swiper-button-next,
    .photo-gallery-slider .swiper-button-prev {
        color: white;
    }

    .photo-gallery-slider .swiper-button-next,
    .photo-gallery-slider .swiper-button-prev {
        background-color: rgba(0, 0, 0, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .photo-gallery-slider .swiper-button-next::after,
    .photo-gallery-slider .swiper-button-prev::after {
        font-size: 18px;
    }

    #calendar-dates .is-selected {
        background-color: #1f2937;

        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
    }

    .line-clamp-custom {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;

        word-break: break-all;

    }
</style>
@endpush

@section('content')

@can('update', $currentPerangkatDaerah)
<div class="bg-[#1e4e7c] text-white shadow-lg">
    <div
        class="container mx-auto px-6 py-3 flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
        <div class="mb-2 sm:mb-0">
            <h2 class="font-bold text-lg">Panel Kontrol Perangkat Daerah</h2>
            <p class="text-sm opacity-80">Anda memiliki akses untuk mengelola halaman ini.</p>
        </div>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="bg-white/20 hover:bg-white/30 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm flex items-center">
                <i class="fas fa-cog mr-2"></i>
                <span>Kelola Konten</span>
                <i class="fas fa-chevron-down ml-2 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-64 origin-top-right bg-white rounded-md shadow-lg z-50 text-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
                style="display: none;">
                <div class="py-1">
                    <div class="px-4 py-2 text-xs text-gray-400">Halaman Utama Perangkat Daerah</div>

                    <a href="{{ route('admin.perangkat-daerah.berita.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Berita</a>
                    <a href="{{ route('admin.perangkat-daerah.agenda.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Agenda</a>
                    <a href="{{ route('admin.perangkat-daerah.layanan.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Layanan</a>
                    <a href="{{ route('admin.perangkat-daerah.galeri.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Galeri</a>
                    <a href="{{ route('admin.perangkat-daerah.banner.edit', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Banner</a>
                    <a href="{{ route('admin.perangkat-daerah.kontak.edit', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Kontak</a>

                    <div class="border-t border-gray-100 my-1"></div>

                    <div class="px-4 py-2 text-xs text-gray-400">Navigasi</div>
                    <a href="{{ route('admin.perangkat-daerah.profil.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Profil</a>
                    <a href="{{ route('admin.perangkat-daerah.pemerintahan.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Pemerintahan</a>

                    <a href="{{ route('admin.perangkat-daerah.laporan-keuangan.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Laporan Keuangan</a>
                    <a href="{{ route('admin.perangkat-daerah.profil.infografis.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Kelola Halaman Infografis</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

<div class="w-full anim-fade-in-down">
    @php
    $banner = $currentPerangkatDaerah->banner_url;
    $banner_type = $currentPerangkatDaerah->banner_type; // Menggunakan accessor dari model
    $video_id = $currentPerangkatDaerah->youtube_video_id; // Menggunakan accessor dari model
    @endphp

    <div class="relative w-full h-[60vh] md:h-[50vh] bg-black shadow-lg overflow-hidden">

        @if ($banner_type === 'image_file')
        <div class="absolute inset-0 w-full h-full bg-cover bg-center"
            style="background-image: url('{{ asset('storage/' . $banner) }}');"></div>
        @elseif ($banner_type === 'video_file')
        <video
            class="absolute top-1/2 left-1/2 w-auto h-auto min-w-full min-h-full object-cover transform -translate-x-1/2 -translate-y-1/2 z-0"
            autoplay loop muted playsinline>
            <source src="{{ asset('storage/' . $banner) }}" type="video/mp4">
        </video>
        @elseif ($banner_type === 'youtube' && $video_id)
        <div class="absolute top-0 left-0 w-full h-full">
            <iframe class="w-full h-full scale-[1.3]"
                src="https://www.youtube.com/embed/{{ $video_id }}?autoplay=1&mute=1&loop=1&playlist={{ $video_id }}&controls=0&showinfo=0&autohide=1&modestbranding=1&iv_load_policy=3&rel=0"
                frameborder="0" allow="autoplay; encrypted-media"></iframe>
        </div>
        @else
        <div class="absolute inset-0 w-full h-full bg-cover bg-center"
            style="background-image: url('https://placehold.co/1920x1080/e2e8f0/64748b?text=Banner');"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        <div class="relative z-10 h-full flex flex-col items-center justify-end text-white text-center p-6 sm:p-10">

            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white drop-shadow-lg">
                {{ $currentPerangkatDaerah->name }}
            </h1>
            <p class="mt-2 text-lg text-gray-200 drop-shadow-lg max-w-3xl">
                {{ $currentPerangkatDaerah->description ?? 'Informasi, Layanan, dan Berita Terkini dari Instansi Kami.'
                }}
            </p>
        </div>
    </div>
</div>

<div class="bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">

            <div class="lg:col-span-1 anim-fade-in-up" style="--anim-delay: 200ms;">
                <div class="bg-white border border-gray-200 rounded-lg p-5 h-full shadow-sm">
                    <h3 class="font-bold mb-4 text-[#1E4E7C]">PALING POPULER</h3>
                    <ul class="space-y-4 text-sm">
                        @forelse ($beritaPopuler as $populer)
                        <li class="flex items-start group">
                            <span
                                class="bg-[#1E4E7C] text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-md mr-3 mt-0.5 flex-shrink-0">{{
                                $loop->iteration }}</span>

                            <a href="{{ route('berita.show', $populer->slug) }}"
                                class="text-gray-800 font-medium group-hover:text-[#FF3B00] transition">{{
                                $populer->judul }}</a>
                        </li>
                        @empty
                        <p class="text-xs text-gray-500">Belum ada berita populer.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-2 anim-fade-in-up" style="--anim-delay: 300ms;">
                <div class="bg-white border border-gray-200 rounded-lg p-5 h-full shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-[#1E4E7C]">BERITA TERKINI</h3>
                        <a href="{{ route('perangkat.berita.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                            Lihat Semua <span
                                class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                        </a>
                    </div>
                    @if ($beritaTerkini->isNotEmpty())
                    <div class="swiper hero-news-slider h-[300px] md:h-[400px]">
                        <div class="swiper-wrapper">
                            @foreach ($beritaTerkini as $berita)
                            <div class="swiper-slide">
                                <a href="{{ route('berita.show', $berita->slug) }}"
                                    style="background-image: url('{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/1200x800/e2e8f0/64748b?text=Berita' }}');">
                                    <div class="overlay"></div>
                                    <div class="slide-content">
                                        <h3>{{ $berita->judul }}</h3>
                                        <p>{{ Str::limit($berita->excerpt, 100) }}</p>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    @else
                    <div class="flex items-center justify-center h-full text-gray-500">Belum ada berita terkini.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12 anim-fade-in-up" style="--anim-delay: 400ms;">
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-5 h-full shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-[#1E4E7C]">ACARA MENDATANG</h3>
                    <a href="{{ route('perangkat.agenda', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                        Lihat Semua <span class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                    </a>
                </div>
                @if ($agendas->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($agendas as $agenda)
                    <a href="#" class="block group p-3 rounded-md hover:bg-gray-50 transition-colors">
                        <h4 class="font-bold text-lg text-gray-800 group-hover:text-[#FF3B00] transition">{{
                            $agenda->judul }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit(strip_tags($agenda->deskripsi), 150) }}</p>
                        <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-calendar-alt mr-1"></i> {{
                            \Carbon\Carbon::parse($agenda->tanggal_mulai)->translatedFormat('d F Y') }}</p>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="flex items-center justify-center h-full text-gray-500">
                    <p>Belum ada acara mendatang.</p>
                </div>
                @endif
            </div>
            <div class="bg-white rounded-lg p-5 shadow-lg flex flex-col h-full">
                <div class="flex justify-between items-center mb-3">
                    <button id="prev-month-btn" class="p-2 rounded-full hover:bg-gray-100 transition"><i
                            class="fas fa-chevron-left"></i></button>
                    <h4 id="month-year-title" class="font-bold text-[#1E4E7C] text-lg"></h4>
                    <button id="next-month-btn" class="p-2 rounded-full hover:bg-gray-100 transition"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
                <hr>
                <div class="grid grid-cols-7 text-center text-xs font-semibold text-gray-400 mt-3 mb-2">
                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                </div>
                <div id="calendar-dates" class="grid grid-cols-7 text-center text-sm"></div>
                <div id="agenda-list" class="mt-4 space-y-2 flex-grow overflow-y-auto pr-2" style="max-height: 150px;">
                </div>
            </div>
        </div>

        <div class="mb-12 anim-fade-in-up" style="--anim-delay: 500ms;">
            <div class="flex justify-between items-center mb-8 px-2">
                <h3 class="font-bold text-2xl text-[#1E4E7C]">Layanan Publik</h3>
                @if($layanans->count() >= 3)
                <a href="{{ route('perangkat.layanan.index', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                    Lihat Semua <span class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                </a>
                @endif
            </div>
            @if ($layanans->isNotEmpty())
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($layanans->take(6) as $layanan)
                <div
                    class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition-transform duration-300">
                    <div
                        class="bg-[#1E4E7C]/10 text-[#1E4E7C] w-20 h-20 rounded-full flex items-center justify-center mb-4">
                        <i class="{{ $layanan->icon ?? 'fas fa-concierge-bell' }} text-4xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $layanan->nama }}</h4>
                    <p class="text-gray-600 text-sm mb-6 flex-grow line-clamp-custom">{{
                        Str::limit(strip_tags($layanan->deskripsi), 120) ?? 'Informasi lebih lanjut tersedia.' }}</p>
                    <a href="{{ route('perangkat.layanan.detail', ['perangkatDaerah' => $currentPerangkatDaerah->slug, 'layanan' => $layanan]) }}"
                        class="mt-auto inline-block bg-[#1E4E7C] text-white font-bold py-2 px-6 rounded-lg hover:brightness-90 transition-all duration-300 w-full">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500">
                <i class="fas fa-info-circle text-4xl mb-4"></i>
                <p>Belum ada layanan yang terdaftar untuk instansi ini.</p>
            </div>
            @endif
        </div>

        <div class="anim-fade-in-up pb-12" style="--anim-delay: 600ms;">
            <h3 class="font-bold text-2xl text-center mb-6 text-[#1E4E7C]">Galeri</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold text-xl text-gray-800">Video Unggulan</h4>
                        @if (($galeriVideo ?? collect())->isNotEmpty())
                        <a href="{{ route('perangkat.galeri.video', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                            Lihat Semua <span
                                class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                        </a>
                        @endif
                    </div>
                    <div class="flex-grow">
                        @if (($galeriVideo ?? collect())->isNotEmpty())
                        <div class="swiper video-gallery-slider shadow-md rounded-lg aspect-video">
                            <div class="swiper-wrapper">
                                @foreach ($galeriVideo as $video)
                                <div class="swiper-slide bg-black">
                                    @if ($video->tipe === 'video_upload')
                                    <video class="w-full h-full object-contain" controls
                                        poster="{{ $video->thumbnail_url ? asset('storage/' . $video->thumbnail_url) : '' }}">
                                        <source src="{{ asset('storage/' . $video->file_url) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                    @elseif($video->tipe === 'video_yt')
                                    @php
                                    $videoId = null;
                                    $pattern =
                                    '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
                                    if (preg_match($pattern, $video->file_url, $matches)) { $videoId = $matches[1]; }
                                    $embedUrl = $videoId ? 'https://www.youtube-nocookie.com/embed/' . $videoId : '';
                                    @endphp
                                    @if ($embedUrl)
                                    <iframe class="w-full h-full" src="{{ $embedUrl }}" title="{{ $video->judul }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-white bg-gray-800">
                                        URL YouTube tidak valid.</div>
                                    @endif
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                        @else
                        <div
                            class="w-full h-[250px] sm:h-[450px] bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-500">
                            <i class="fas fa-video-slash fa-3x mb-4 text-gray-300"></i>
                            <p class="font-semibold">Video Belum Tersedia</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white rounded-xl shadow-lg p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold text-xl text-gray-800">Koleksi Foto</h4>
                        @if (($galeriFoto ?? collect())->isNotEmpty())
                        <a href="{{ route('perangkat.galeri.foto', ['perangkatDaerah' => $currentPerangkatDaerah->slug]) }}" class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                            Lihat Semua <span
                                class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                        </a>
                        @endif
                    </div>
                    <div class="flex-grow">
                        @if (($galeriFoto ?? collect())->isNotEmpty())
                        <div class="swiper photo-gallery-slider shadow-md rounded-lg aspect-video">
                            <div class="swiper-wrapper">
                                @foreach ($galeriFoto as $foto)
                                <div class="swiper-slide">
                                    <a href="{{ asset('storage/' . $foto->file_url) }}"
                                        data-lightbox="galeri-foto-slider" data-title="{{ $foto->judul }}">
                                        <img src="{{ asset('storage/' . $foto->file_url) }}" alt="{{ $foto->judul }}"
                                            class="w-full h-full object-cover">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        @else
                        <div
                            class="w-full h-[250px] sm:h-[450px] bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-500">
                            <i class="fas fa-camera-retro fa-3x mb-4 text-gray-300"></i>
                            <p class="font-semibold">Foto Belum Tersedia</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

@php
$agendaDataForJs = $agendaDataForJs ?? (object)[];
$loopBerita = ($beritaTerkini ?? collect())->count() > 1;
$loopVideo = ($galeriVideo ?? collect())->count() > 1;
$loopFoto = ($galeriFoto ?? collect())->count() > 1;
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const monthYearTitle = document.getElementById('month-year-title');
        const calendarDatesContainer = document.getElementById('calendar-dates');
        const prevMonthBtn = document.getElementById('prev-month-btn');
        const nextMonthBtn = document.getElementById('next-month-btn');
        const agendaListContainer = document.getElementById('agenda-list');

        if (monthYearTitle && calendarDatesContainer && prevMonthBtn && nextMonthBtn && agendaListContainer) {
            const agendaData = @json($agendaDataForJs);
            const today = new Date();
            let currentDate = new Date();
            currentDate.setDate(1);

            function buildCalendarGrid() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                monthYearTitle.textContent = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(currentDate);
                const firstDayOfMonth = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const dayOffset = (firstDayOfMonth === 0) ? 6 : firstDayOfMonth - 1;
                let calendarHtml = '';
                for (let i = 0; i < dayOffset; i++) { calendarHtml += '<div></div>'; }
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const hasAgenda = agendaData[dateStr];
                    const isToday = (day === today.getDate() && month === today.getMonth() && year === today.getFullYear());
                    let classes = 'w-9 h-9 flex items-center justify-center rounded-full transition-all duration-200 cursor-pointer';
                    if (isToday) {
                        classes += ' bg-[#1E4E7C] text-white font-bold';
                        if (hasAgenda) classes += ' ring-2 ring-offset-1 ring-blue-400';
                    } else if (hasAgenda) {
                        classes += ' bg-gray-200 text-gray-800 font-bold';
                    } else {
                        classes += ' hover:bg-gray-100';
                    }
                    calendarHtml += `<button class="${classes}" data-date="${dateStr}">${day}</button>`;
                }
                calendarDatesContainer.innerHTML = calendarHtml;
                addDateClickListeners();
            }

            function renderAgendaForMonth(year, month) {
                agendaListContainer.innerHTML = '';
                let hasAgendaThisMonth = false;
                const agendasThisMonth = {};
                Object.keys(agendaData).forEach(dateStr => {
                    const [yearStr, monthStr, dayStr] = dateStr.split('-');
                    const agendaDate = new Date(parseInt(yearStr), parseInt(monthStr) - 1, parseInt(dayStr));
                    if (agendaDate.getFullYear() === year && agendaDate.getMonth() === month) {
                        hasAgendaThisMonth = true;
                        agendasThisMonth[dateStr] = agendaData[dateStr];
                    }
                });
                if (hasAgendaThisMonth) {
                    Object.keys(agendasThisMonth).sort().forEach(dateStr => {
                        const date = new Date(dateStr + 'T00:00:00');
                        const dateTitle = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long' }).format(date);
                        agendaListContainer.innerHTML += `<h4 class="font-bold text-md text-[#1E4E7C] pt-4 pb-2 border-b">${dateTitle}</h4>`;
                        agendasThisMonth[dateStr].forEach(agenda => {
                            agendaListContainer.innerHTML += `<div class="flex items-start py-2 ml-2"><div class="w-auto text-left font-semibold text-sm text-gray-800 pr-3 flex-shrink-0" style="min-width: 150px;">${agenda.time}</div><div class="pl-3 text-sm text-gray-700 border-l">${agenda.description}</div></div>`;
                        });
                    });
                } else {
                    agendaListContainer.innerHTML = '<p class="text-sm text-center text-gray-500 py-4">Tidak ada agenda di bulan ini.</p>';
                }
            }

            function renderAgendaForDay(dateStr) {
                agendaListContainer.innerHTML = '';
                const agendas = agendaData[dateStr];
                const date = new Date(dateStr + 'T00:00:00');
                const dateTitle = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long' }).format(date);
                agendaListContainer.innerHTML = `<div class="flex justify-between items-center pb-2 border-b"><h4 class="font-bold text-md text-[#1E4E7C]">${dateTitle}</h4><button id="show-all-btn" class="text-sm text-blue-600 hover:underline">&larr; Lihat semua bulan ini</button></div>`;
                if (agendas && agendas.length > 0) {
                    agendas.forEach(agenda => {
                        agendaListContainer.innerHTML += `<div class="flex items-start py-2 ml-2"><div class="w-auto text-left font-semibold text-sm text-gray-800 pr-3 flex-shrink-0" style="min-width: 150px;">${agenda.time}</div><div class="pl-3 text-sm text-gray-700 border-l">${agenda.description}</div></div>`;
                    });
                } else {
                    agendaListContainer.innerHTML += '<p class="text-sm text-center text-gray-500 py-4">Tidak ada agenda pada tanggal ini.</p>';
                }
                document.getElementById('show-all-btn').addEventListener('click', () => {
                    const currentlySelected = document.querySelector('.is-selected');
                    if (currentlySelected) { currentlySelected.classList.remove('is-selected', 'bg-blue-500', 'text-white'); }
                    renderAgendaForMonth(currentDate.getFullYear(), currentDate.getMonth());
                });
            }

            function addDateClickListeners() {
                document.querySelectorAll('#calendar-dates button').forEach(button => {
                    button.addEventListener('click', () => {
                        const dateStr = button.dataset.date;
                        renderAgendaForDay(dateStr);
                        const currentlySelected = document.querySelector('.is-selected');
                        if (currentlySelected) { currentlySelected.classList.remove('is-selected', 'bg-blue-500', 'text-white'); }
                        button.classList.add('is-selected', 'bg-blue-500', 'text-white');
                        button.classList.remove('bg-gray-200');
                    });
                });
            }

            function initializeView() {
                buildCalendarGrid();
                renderAgendaForMonth(currentDate.getFullYear(), currentDate.getMonth());
            }

            prevMonthBtn.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); initializeView(); });
            nextMonthBtn.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); initializeView(); });
            initializeView();
        }

        lightbox.option({ 'albumLabel': 'Gambar %1 dari %2', 'wrapAround': true });

        if (document.querySelector('.hero-news-slider')) {
            new Swiper('.hero-news-slider', { slidesPerView: 1, spaceBetween: 30, loop: @json($loopBerita), autoplay: { delay: 4000, disableOnInteraction: false }, navigation: { nextEl: '.hero-news-slider .swiper-button-next', prevEl: '.hero-news-slider .swiper-button-prev' } });
        }
        if (document.querySelector('.video-gallery-slider')) {
            new Swiper('.video-gallery-slider', { loop: @json($loopVideo), autoplay: { delay: 3500, disableOnInteraction: false }, navigation: { nextEl: '.video-gallery-slider .swiper-button-next', prevEl: '.video-gallery-slider .swiper-button-prev' } });
        }
        if (document.querySelector('.photo-gallery-slider')) {
            new Swiper('.photo-gallery-slider', { loop: @json($loopFoto), autoplay: { delay: 3500, disableOnInteraction: false }, navigation: { nextEl: '.photo-gallery-slider .swiper-button-next', prevEl: '.photo-gallery-slider .swiper-button-prev' } });
        }
    });
</script>
@endpush