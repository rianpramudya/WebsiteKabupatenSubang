@php
if ($tenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
$baseRouteName = $isKecamatan ? 'admin.kecamatan.' : 'admin.perangkat-daerah.';
$routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
$tenantName = $tenant->name;
} else {
$baseRouteName = 'admin.kabupaten.';
$routeParameters = []; // Rute kabupaten tidak butuh parameter
$tenantName = 'Kabupaten';
}
@endphp

@extends('layouts.app')

@section('title', 'Tambah Penghargaan Baru - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Penghargaan Baru untuk {{ $tenantName }}</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">
        <form action="{{ route($baseRouteName . 'profil.penghargaan.store', $routeParameters) }}" method="POST">
            @include('admin.profil_CRUD.penghargaan_CRUD._form', [
            'tenant' => $tenant,
            'penghargaan' => new \App\Models\Penghargaan,
            'baseRouteName' => $baseRouteName,
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

    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection