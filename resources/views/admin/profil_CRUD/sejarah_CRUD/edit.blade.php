@extends('layouts.app')

@php
// [PERBAIKAN] Logika ini sekarang menangani parameter tenant DAN model

// 1. Tentukan awalan rute dan parameter tenant terlebih dahulu
if ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
$baseRouteName = 'admin.kecamatan.';
$routeParameters = ['kecamatan' => $tenant->slug];
} elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
$baseRouteName = 'admin.perangkat-daerah.';
$routeParameters = ['perangkatDaerah' => $tenant->slug];
} else {
$baseRouteName = 'admin.kabupaten.';
$routeParameters = [];
}

// 2. Tambahkan parameter model 'sejarah' ke dalam array yang sudah ada
// Ini memastikan parameter 'sejarah' selalu ada untuk rute update
$routeParameters['sejarah'] = $sejarah->id;
@endphp

@section('title', 'Edit Data Sejarah - ' . $tenant->name)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Timeline Sejarah</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">
        {{-- [FIX] Form action sekarang dinamis --}}
        <form action="{{ route($baseRouteName . 'profil.sejarah.update', $routeParameters) }}" method="POST">
            @method('PUT')
            {{-- Partial _form sekarang akan menerima variabel $tenant dan $sejarah --}}
            @include('admin.profil_CRUD.sejarah_CRUD._form')
        </form>
    </div>
</div>

{{-- [DITAMBAHKAN] Blok CSS dan JavaScript untuk animasi --}}
<style>
    /* Keyframes untuk animasi fade-in dan fade-out */
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

    /* Terapkan animasi fade-in saat halaman dimuat */
    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Terapkan animasi fade-out saat body memiliki kelas 'fading-out' */
    body.fading-out #page-content {
        animation: fadeOut 0.5s ease-out forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fadeOutDuration = 500; 
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(form a)');

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
@endsection