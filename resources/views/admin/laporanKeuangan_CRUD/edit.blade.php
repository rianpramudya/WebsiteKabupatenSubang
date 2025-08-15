@extends('layouts.app')

@php
// Blok ini sudah benar
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;

if ($tenant) {
$routePrefix = $isKecamatan ? 'admin.kecamatan.laporan-keuangan' : 'admin.perangkat-daerah.laporan-keuangan';
$routeParameters = [$isKecamatan ? 'kecamatan' : 'perangkatDaerah' => $tenant->slug];
$tenantName = $tenant->name;
} else {
$routePrefix = 'admin.kabupaten.laporan-keuangan';
$routeParameters = [];
$tenantName = 'Kabupaten';
}
@endphp

{{-- PERBAIKAN: Gunakan $tenantName yang aman dari null --}}
@section('title', 'Edit Laporan Keuangan - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            {{-- PERBAIKAN: Gunakan $routeParameters yang aman dari null --}}
            <a href="{{ route($routePrefix . '.index', $routeParameters) }}"
                class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Kelola Laporan
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Laporan Keuangan</h1>
        {{-- PERBAIKAN: Gunakan $tenantName yang aman dari null --}}
        <p class="text-lg text-gray-500 mb-8">Untuk <span class="font-semibold text-gray-700">{{ $tenantName }}</span>
        </p>

        {{-- PERBAIKAN: Gunakan $routeParameters dan gabungkan dengan ID Laporan --}}
        <form
            action="{{ route($routePrefix . '.update', array_merge($routeParameters, ['laporan_keuangan' => $laporanKeuangan->id])) }}"
            method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.laporanKeuangan_CRUD._form', [
            'laporanKeuangan' => $laporanKeuangan,
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