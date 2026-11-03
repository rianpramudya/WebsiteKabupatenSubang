@extends('layouts.app')

@php
$routePrefix = 'admin.kabupaten.agenda'; // Default
$routeParameters = [];

if ($tenant instanceof \App\Models\PerangkatDaerah) {
$routePrefix = 'admin.perangkat-daerah.agenda';
$routeParameters = ['perangkatDaerah' => $tenant->slug];
} elseif ($tenant instanceof \App\Models\Kecamatan) {
$routePrefix = 'admin.kecamatan.agenda';
$routeParameters = ['kecamatan' => $tenant->slug];
}

$formActionUrl = route($routePrefix . '.store', $routeParameters);
$backRouteUrl = route($routePrefix . '.index', $routeParameters);
@endphp

@section('title', 'Tambah Agenda Baru')

@section('content')
<div id="page-content" class="container mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Tambah Agenda Baru</h1>
        <a href="{{ $backRouteUrl }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Daftar Agenda</a>
    </div>

    <form action="{{ $formActionUrl }}" method="POST" class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        @include('admin.agenda_CRUD._form', [
        'agenda' => new \App\Models\Agenda(),
        'kecamatans' => $kecamatans,
        'perangkatDaerahs' => $perangkatDaerahs,
        'backRouteUrl' => $backRouteUrl,
        ])
    </form>
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

        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(form a)');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Hentikan navigasi standar

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