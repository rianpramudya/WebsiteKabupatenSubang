@php
// [PERBAIKAN] Logika lengkap untuk menangani semua level peran
if ($tenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
$baseRouteName = $isKecamatan ? 'admin.kecamatan.wisata.' : 'admin.perangkat-daerah.wisata.';
$routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
$tenantName = $tenant->name;
} else {
$baseRouteName = 'admin.kabupaten.wisata.';
$routeParameters = [];
$tenantName = 'Kabupaten';
}
$crudRoutePrefix = $baseRouteName . 'objek-wisata';
@endphp

@extends('layouts.app')

@section('title', 'Edit Objek Wisata - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route($crudRoutePrefix . '.index', $routeParameters) }}"
        class="text-gray-600 hover:text-gray-900 mb-4 inline-flex items-center transition-colors">
        <span class="mr-2">&larr;</span>
        Kembali ke Daftar Objek Wisata
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data: {{ $objekWisata->nama }}</h1>
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
        <form
            action="{{ route($crudRoutePrefix . '.update', array_merge($routeParameters, ['objekWisata' => $objekWisata->id])) }}"
            method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.wisata_CRUD.objek_wisata_CRUD._form', [
            'objekWisata' => $objekWisata,
            'kecamatan' => $kecamatan,
            'tenant' => $tenant,
            'crudRoutePrefix' => $crudRoutePrefix,
            'routeParameters' => $routeParameters
            ])
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
                setTimeout(() => { window.location.href = link.href; }, fadeOutDuration);
            });
        });
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) { document.body.classList.remove('fading-out'); }
        });
    });
</script>
@endsection