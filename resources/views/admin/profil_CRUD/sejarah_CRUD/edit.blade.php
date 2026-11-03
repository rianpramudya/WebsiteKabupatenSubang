@extends('layouts.app')

@php

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

$routeParameters['sejarah'] = $sejarah->id;
@endphp

@section('title', 'Edit Data Sejarah - ' . $tenant->name)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Timeline Sejarah</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">

        <form action="{{ route($baseRouteName . 'profil.sejarah.update', $routeParameters) }}" method="POST">
            @method('PUT')

            @include('admin.profil_CRUD.sejarah_CRUD._form')
        </form>
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