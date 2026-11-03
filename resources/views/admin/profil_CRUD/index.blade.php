@extends('layouts.app')

@php
$hasTenant = isset($tenant);

if ($hasTenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
$routePrefix = $isKecamatan ? 'admin.kecamatan.profil' : 'admin.perangkat-daerah.profil';
$routeParameters = [$isKecamatan ? 'kecamatan' : 'perangkatDaerah' => $tenant->slug];
$pageTitle = 'Kelola Profil ' . $tenant->name;
$headerTitle = 'Kelola Profil: ' . $tenant->name;
$headerSubtitle = 'Pilih bagian profil yang ingin Anda kelola.';
} else {
$routePrefix = 'admin.kabupaten.profil';
$routeParameters = []; // Rute kabupaten tidak butuh parameter slug.
$pageTitle = 'Kelola Profil Kabupaten';
$headerTitle = 'Kelola Profil Level Kabupaten';
$headerSubtitle = 'Menu ini berisi item-item profil yang berlaku secara global untuk Kabupaten.';
}
@endphp

@section('title', $pageTitle)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@endpush

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $headerTitle }}</h1>
        <p class="text-gray-500 mt-1">{{ $headerSubtitle }}</p>
    </div>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <p class="font-semibold">Sukses!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        <a href="{{ route($routePrefix . '.visimisi.edit', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full"><i class="fas fa-bullseye fa-lg text-blue-600"></i></div>
                <h2 class="ml-4 text-xl font-semibold text-gray-700">Visi & Misi</h2>
            </div>
            <p class="mt-3 text-gray-600 text-sm">Ubah pernyataan visi dan misi.</p>
        </a>

        <a href="{{ route($routePrefix . '.sejarah.index', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full"><i class="fas fa-landmark fa-lg text-yellow-600"></i></div>
                <h2 class="ml-4 text-xl font-semibold text-gray-700">Sejarah</h2>
            </div>
            <p class="mt-3 text-gray-600 text-sm">Kelola timeline dan narasi sejarah.</p>
        </a>

        <a href="{{ route($routePrefix . '.wilayah.edit', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full"><i class="fas fa-map-marked-alt fa-lg text-green-600"></i>
                </div>
                <h2 class="ml-4 text-xl font-semibold text-gray-700">Wilayah</h2>
            </div>
            <p class="mt-3 text-gray-600 text-sm">Kelola informasi geografis dan topografi.</p>
        </a>

        <a href="{{ route($routePrefix . '.penghargaan.index', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full"><i class="fas fa-trophy fa-lg text-purple-600"></i></div>
                <h2 class="ml-4 text-xl font-semibold text-gray-700">Penghargaan</h2>
            </div>
            <p class="mt-3 text-gray-600 text-sm">Kelola daftar penghargaan yang telah diraih.</p>
        </a>

    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(10px);
        }
    }

    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }

    body.fading-out #page-content {
        animation: fadeOut 0.5s ease-out forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fadeOutDuration = 500;
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                if (link.closest('form[onsubmit]')) {
                    return;
                }
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
@endsection