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

@section('title', 'Sejarah - ' . $namaKonteks)

@push('styles')
<style>
    /* Lightbox Styles */
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .lightbox.show {
        opacity: 1;
        visibility: visible;
    }

    .lightbox-content {
        position: relative;
        max-width: 90vw;
        max-height: 85vh;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .lightbox.show .lightbox-content {
        transform: scale(1);
    }

    .lightbox-content img {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 85vh;
        border-radius: 0.5rem;
    }

    .lightbox-close {
        position: absolute;
        top: -10px;
        right: -10px;
        background: white;
        color: black;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        cursor: pointer;
        font-size: 1.2rem;
        line-height: 1;
    }

    /* Timeline Styles */
    .timeline-item {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .timeline-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .timeline-line {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0;
        width: 4px;
        background-color: #e5e7eb;
    }

    .timeline-dot {
        position: absolute;
        left: 50%;
        top: 1rem;
        transform: translateX(-50%);
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 9999px;
        background-color: white;
        border: 4px solid #1E4E7C;
        z-index: 10;
    }

    .timeline-content {
        transition: all 0.8s ease-out;
    }

    .fade-in-left {
        transform: translateX(-50px);
    }

    .fade-in-right {
        transform: translateX(50px);
    }

    .fade-in-up {
        transform: translateY(50px);
    }

    .is-visible.fade-in-left,
    .is-visible.fade-in-right,
    .is-visible.fade-in-up {
        transform: translate(0, 0);
        opacity: 1;
    }

    @media (max-width: 1023px) {
        .timeline-line {
            left: 1.25rem;
            transform: translateX(-50%);
        }

        .timeline-dot {
            left: 1.25rem;
        }

        .timeline-content {
            width: 100%;
            padding-left: 3.5rem;
        }
    }
</style>
@endpush

@section('content')
@php
// [PERBAIKAN] Variabel logoUrl didefinisikan di sini agar bisa mengakses $profil
// dan variabel lain yang dikirim dari controller
$logoUrl = $profil->logo_url ?? asset('img/logo-subang-color.png');

$galleryImages = isset($profil) ? array_filter([
$profil->sejarah_img_1,
$profil->sejarah_img_2,
$profil->sejarah_img_3,
]) : [];
@endphp

<div class="bg-gray-100">
    {{-- Banner Section --}}
    <div class="bg-gray-800 text-white py-16 text-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1505664194779-8beaceb93744?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aGlzdG9yeXxlbnwwfHwwfHx8MA%D%D');">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-[#FCE405]">Sejarah</h1>
            <p class="text-gray-300 mt-2 text-xl">{{ $namaKonteks }}</p>
        </div>
    </div>

    {{-- Main Content: Timeline and Sidebar --}}
    <div class="container mx-auto px-4 sm:px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="relative">
                    <div class="timeline-line hidden lg:block"></div>
                    <div class="timeline-item fade-in-up space-y-4">
                        <div class="bg-white p-8 rounded-2xl shadow-lg border-t-4 border-[#1E4E7C]">
                            <h2 class="text-3xl font-bold text-[#1E4E7C] mb-4">Awal Mula</h2>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">{!! $profil->sejarah ?? 'Data
                                sejarah awal belum tersedia.' !!}</div>
                        </div>
                    </div>
                    @foreach ($sejarah_items as $item)
                    @php
                    $fadeClass = $loop->odd ? 'fade-in-left' : 'fade-in-right';
                    @endphp
                    <div class="relative mt-12 timeline-item {{ $fadeClass }}">
                        <div class="timeline-dot"></div>
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            @if($loop->odd)
                            <div class="timeline-content lg:order-last">
                                <div class="bg-white p-6 rounded-2xl shadow-lg">
                                    <div class="prose break-words max-w-none text-gray-700">{!! $item->deskripsi !!}
                                    </div>
                                </div>
                            </div>
                            <div class="lg:pl-8 mb-4 lg:mb-0">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $item->tahun }}</h3>
                                <p class="text-gray-500">{{ $item->judul }}</p>
                            </div>
                            @else
                            <div class="lg:text-right lg:pr-8 mb-4 lg:mb-0">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $item->tahun }}</h3>
                                <p class="text-gray-500">{{ $item->judul }}</p>
                            </div>
                            <div class="timeline-content">
                                <div class="bg-white p-6 rounded-2xl shadow-lg">
                                    <div class="prose break-words max-w-none text-gray-700">{!! $item->deskripsi !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-2xl shadow-lg sticky top-24 timeline-item fade-in-up">
                    <h2 class="text-2xl font-bold text-[#1E4E7C] mb-4 border-b pb-3">Arti Lambang</h2>
                    <div class="w-full flex justify-center my-6">
                        <img src="{{ $logoUrl }}" alt="Lambang {{ $namaKonteks }}"
                            class="h-48 transition-transform duration-300 hover:scale-110">
                    </div>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">{!! $profil->arti_lambang ??
                        'Data arti lambang belum tersedia.' !!}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Galeri Gambar Utama Sejarah --}}
    @if(!empty($galleryImages))
    <div class="bg-white py-16">
        <div class="container mx-auto px-4 sm:px-6 md:px-12 lg:px-24">
            <div class="text-center mb-12 timeline-item fade-in-up">
                <h2 class="text-3xl lg:text-4xl font-bold text-[#1E4E7C]">Galeri Momen Bersejarah</h2>
                <p class="text-gray-500 mt-2">Dokumentasi visual perjalanan sejarah.</p>
                <div class="w-24 h-1 bg-[#FCE405] mx-auto mt-4 rounded"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galleryImages as $index => $image)
                <div class="timeline-item fade-in-up" style="transition-delay: {{ ($index + 1) * 0.15 }}s;">
                    <div class="rounded-lg shadow-lg overflow-hidden bg-white p-2">
                        <a href="{{ asset('storage/' . $image) }}" class="gallery-image-link">
                            <div class="w-full aspect-video">
                                <img src="{{ asset('storage/' . $image) }}" alt="Gambar Sejarah {{ $index + 1 }}"
                                    class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300 rounded-md">
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" class="lightbox">
    <span class="lightbox-close">&times;</span>
    <div class="lightbox-content">
        <img src="" id="lightbox-img" alt="Gambar Sejarah Diperbesar">
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Intersection Observer for animations
        const items = document.querySelectorAll('.timeline-item');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, {
            threshold: 0.1
        });
        items.forEach((item, index) => {
            if (!item.style.transitionDelay) {
               item.style.transitionDelay = `${index * 0.1}s`;
            }
            observer.observe(item);
        });

        // Lightbox functionality
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const galleryLinks = document.querySelectorAll('.gallery-image-link');
        const closeBtn = document.querySelector('.lightbox-close');

        if (lightbox && lightboxImg && galleryLinks.length > 0 && closeBtn) {
            galleryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const imgSrc = this.getAttribute('href'); 
                    lightboxImg.setAttribute('src', imgSrc);
                    lightbox.classList.add('show');
                });
            });

            const closeLightbox = () => {
                lightbox.classList.remove('show');
            };

            closeBtn.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
        }
    });
</script>
@endpush