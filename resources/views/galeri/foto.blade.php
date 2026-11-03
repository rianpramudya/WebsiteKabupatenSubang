@extends('layouts.app')

@php
    $judulHalaman = 'Galeri Foto';
    $subJudul = 'Kumpulan foto dari Kabupaten Subang'; // Default

    if (isset($currentPerangkatDaerah)) {
        $judulHalaman = 'Galeri Foto ' . $currentPerangkatDaerah->name;
        $subJudul = 'Kumpulan foto dari ' . $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan)) {
        $judulHalaman = 'Galeri Foto Kecamatan ' . $currentKecamatan->name;
        $subJudul = 'Kumpulan foto dari Kecamatan ' . $currentKecamatan->name;
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
            aspect-ratio: 1 / 1;
            background-color: #f3f4f6;
        }
        .gallery-card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }
        .gallery-card:hover img {
            transform: scale(1.05);
        }
        .card-content {
            padding: 1rem;
        }
        .card-title {
            font-weight: 600;
            color: #1f2937;
            line-height: 1.5;
        }
    </style>
@endpush

@section('content')
<div class="bg-gray-100 py-12 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-[#1E4E7C] tracking-tight">{{ $judulHalaman }}</h1>
            <p class="mt-1 text-gray-600">{{ $subJudul }}</p>
        </div>

        @if ($fotos->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($fotos as $foto)

                    <div class="gallery-card group">
                        <a href="{{ asset('storage/' . $foto->file_url) }}" data-lightbox="galeri-foto" data-title="{{ $foto->judul }}">
                            <div class="gallery-card-image-wrapper">
                                <img src="{{ asset('storage/' . $foto->file_url) }}" alt="{{ $foto->judul }}" onerror="this.src='https://placehold.co/400x400/e2e8f0/64748b?text=Image+Error';">
                            </div>
                        </a>
                        <div class="card-content">
                            <h3 class="card-title truncate" title="{{ $foto->judul }}">{{ $foto->judul }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $fotos->links() }}
            </div>
        @else
             <div class="text-center py-20 bg-white rounded-lg shadow-md">
                <i class="fas fa-image text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">Belum Ada Foto</p>
                <p class="text-gray-400">Saat ini belum ada foto yang dapat ditampilkan.</p>
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true,
          'albumLabel': 'Gambar %1 dari %2'
        })
    </script>
@endpush
