@php
    if ($tenant) {
        $isKecamatan = $tenant instanceof \App\Models\Kecamatan;
        $baseRouteName = $isKecamatan ? 'admin.kecamatan.pemerintahan.' : 'admin.perangkat-daerah.pemerintahan.';
        $routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
        $tenantName = $tenant->name;
    } else {
        $baseRouteName = 'admin.kabupaten.pemerintahan.';
        $routeParameters = [];
        $tenantName = 'Kabupaten';
    }
    $crudRoutePrefix = $baseRouteName . 'wilayah-administrasi';
@endphp

@extends('layouts.app')

@section('title', 'Edit Wilayah Administrasi - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data: {{ $wilayahAdministrasi->nama_desa }}</h1>
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">

        <form action="{{ route($crudRoutePrefix . '.update', array_merge($routeParameters, ['wilayah_administrasi' => $wilayahAdministrasi->id])) }}" method="POST">
            @method('PUT')

            @include('admin.pemerintahan_CRUD.wilayahAdministrasi_CRUD._form', [
                'wilayahAdministrasi' => $wilayahAdministrasi,
                'tenant' => $tenant,
                'crudRoutePrefix' => $crudRoutePrefix,
                'routeParameters' => $routeParameters
            ])
        </form>
    </div>
</div>

@push('styles')
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
@endpush

@push('scripts')
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
@endpush
@endsection