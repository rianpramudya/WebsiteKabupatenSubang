@php
    // [PERBAIKAN] Logika ini sekarang menangani parameter tenant DAN model
    
    // 1. Tentukan awalan rute dan parameter tenant terlebih dahulu
    if ($tenant) {
        $isKecamatan = $tenant instanceof \App\Models\Kecamatan;
        $baseRouteName = $isKecamatan ? 'admin.kecamatan.' : 'admin.perangkat-daerah.';
        $routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
        // Tambahkan definisi $tenantName di sini
        $tenantName = $tenant->name;
    } else {
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = [];
        // Tambahkan definisi $tenantName di sini
        $tenantName = 'Kabupaten';
    }

    // 2. Tambahkan parameter model 'penghargaan' ke dalam array yang sudah ada
    $routeParameters['penghargaan'] = $penghargaan->id;
@endphp

@extends('layouts.app')

@section('title', 'Edit Penghargaan - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Penghargaan</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">
        <form action="{{ route($baseRouteName . 'profil.penghargaan.update', $routeParameters) }}" method="POST">
            @method('PUT')
            @include('admin.profil_CRUD.penghargaan_CRUD._form', ['tenant' => $tenant, 'penghargaan' => $penghargaan])
        </form>
    </div>
</div>

{{-- [DIKEMBALIKAN] Blok CSS dan JavaScript untuk animasi --}}
<style>
    /* Keyframes untuk animasi fade-in dan fade-out */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(10px); }
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
