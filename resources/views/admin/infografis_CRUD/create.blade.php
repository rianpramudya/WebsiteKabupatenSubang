@extends('layouts.app')

@php
    // Blok ini sudah benar dari jawaban sebelumnya
    $isKecamatan = $tenant instanceof \App\Models\Kecamatan;
    
    if ($tenant) {
        $routePrefix = $isKecamatan ? 'admin.kecamatan.profil.infografis' : 'admin.perangkat-daerah.profil.infografis';
        $routeParameters = [$isKecamatan ? 'kecamatan' : 'perangkatDaerah' => $tenant->slug];
        $tenantName = $tenant->name;
    } else {
        $routePrefix = 'admin.kabupaten.infografis';
        $routeParameters = [];
        $tenantName = 'Kabupaten';
    }
@endphp

{{-- [FIXED] Menggunakan variabel $tenantName yang aman dari null --}}
@section('title', 'Tambah Infografis Baru - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    {{-- [FIXED] Judul sekarang dinamis dan aman dari null --}}
    <h2 class="text-2xl font-semibold leading-tight mb-6">Tambah Infografis Baru untuk {{ $tenantName }}</h2>
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-md">
        {{-- [FIXED] Form action sekarang dinamis dan aman dari null --}}
        <form action="{{ route($routePrefix . '.store', $routeParameters) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- [FIXED] Mengirim variabel yang dibutuhkan ke form partial --}}
            @include('admin.infografis_CRUD._form', [
                'tenant' => $tenant,
                'routePrefix' => $routePrefix,
                'routeParameters' => $routeParameters
            ])
        </form>
    </div>
</div>


{{-- [DITAMBAHKAN] Blok CSS dan JavaScript untuk animasi --}}
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