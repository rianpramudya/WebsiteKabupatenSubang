@extends('layouts.app')

@php
    $judulHalaman = 'Galeri Video';
    $subJudul = 'Kumpulan video dari Kabupaten Subang'; // Default

    if (isset($currentPerangkatDaerah)) {
        $judulHalaman = 'Galeri Video ' . $currentPerangkatDaerah->name;
        $subJudul = 'Kumpulan video dari ' . $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan)) {
        $judulHalaman = 'Galeri Video Kecamatan ' . $currentKecamatan->name;
        $subJudul = 'Kumpulan video dari Kecamatan ' . $currentKecamatan->name;
    }
@endphp

@section('title', $judulHalaman)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>

        .gallery-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        .gallery-card-image-wrapper {
            position: relative;
            aspect-ratio: 16 / 9;
            background-color: #f3f4f6;
        }
        .gallery-card-image-wrapper img,
        .gallery-card-image-wrapper video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }
        .gallery-card:hover img,
        .gallery-card:hover video {
            transform: scale(1.05);
        }
        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
        }
        .group:hover .play-icon {
            opacity: 1;
        }
        .card-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
        }
        .card-content {
            padding: 1rem;
        }
        .card-title {
            font-weight: 600;
            color: #1f2937;
            line-height: 1.5;
        }

        .lb-video {
            width: 80vw;
            height: 80vh;
            max-width: 1120px;
            max-height: 630px;
        }
    </style>
@endpush

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-[#1E4E7C] tracking-tight">{{ $judulHalaman }}</h1>
            <p class="mt-1 text-gray-600">{{ $subJudul }}</p>
        </div>

        @if ($videos->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($videos as $video)

                    <div class="gallery-card group">
                        @if ($video->tipe === 'video_yt')
                            @php
                                $videoId = null;
                                $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
                                if (preg_match($pattern, $video->file_url, $matches)) {
                                    $videoId = $matches[1];
                                }
                                $embedUrl = $videoId ? "https://www.youtube.com/embed/" . $videoId : '#';
                                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'https://placehold.co/640x360/e2e8f0/64748b?text=Invalid+URL';
                            @endphp

                            <a href="{{ $embedUrl }}" data-lightbox="youtube-video" data-title="{{ $video->judul }}">
                                <div class="gallery-card-image-wrapper">
                                    <img src="{{ $thumbnailUrl }}" alt="Thumbnail: {{ $video->judul }}" onerror="this.src='https://placehold.co/640x360/e2e8f0/64748b?text=Video+Error';">
                                    <div class="play-icon"><i class="fab fa-youtube text-white text-3xl"></i></div>
                                    <span class="card-badge bg-red-600">YouTube</span>
                                </div>
                            </a>

                        @elseif ($video->tipe === 'video_upload')
                             <a href="{{ asset('storage/' . $video->file_url) }}" data-lightbox="uploaded-video" data-title="{{ $video->judul }}">
                                <div class="gallery-card-image-wrapper">
                                    <video preload="metadata" muted class="w-full h-full object-cover">
                                        <source src="{{ asset('storage/' . $video->file_url) }}#t=0.5" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                    <div class="play-icon"><i class="fas fa-play text-white text-2xl ml-1"></i></div>
                                    <span class="card-badge bg-blue-600">Upload</span>
                                </div>
                            </a>
                        @endif

                        <div class="card-content">
                            <h3 class="card-title truncate" title="{{ $video->judul }}">{{ $video->judul }}</h3>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="mt-12">
                {{ $videos->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-lg shadow-md">
                <i class="fas fa-video-slash text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">Belum Ada Video</p>
                <p class="text-gray-400">Saat ini belum ada video yang dapat ditampilkan.</p>
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <script>
        $(document).ready(function() {

            lightbox.option({
              'resizeDuration': 200,
              'wrapAround': true,
              'albumLabel': "Video %1 dari %2"
            });

            $(document).on('click', '[data-lightbox="youtube-video"]', function(event) {
                event.preventDefault();
                const videoUrl = $(this).attr('href');
                const videoTitle = $(this).data('title');
                const iframeContent = `<iframe class="lb-video" src="${videoUrl}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;

                lightbox.start(
                    $(this),
                    [{'href': videoUrl, 'title': videoTitle, 'html': iframeContent}],
                    { albumLabel: '', wrapAround: false }
                );
            });
        });
    </script>
@endpush
