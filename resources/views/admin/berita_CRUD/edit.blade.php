@php
// [PERBAIKAN] Logika lengkap untuk menangani semua level peran
if ($tenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
$routePrefix = $isKecamatan ? 'admin.kecamatan.berita' : 'admin.perangkat-daerah.berita';
$routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
$tenantName = $tenant->name;
} else {
$routePrefix = 'admin.kabupaten.berita';
$routeParameters = [];
$tenantName = 'Kabupaten';
}
$formActionUrl = route($routePrefix . '.update', array_merge($routeParameters, ['berita' => $berita]));
$backRouteUrl = route($routePrefix . '.index', $routeParameters);
@endphp

@extends('layouts.app')
@section('title', 'Edit Berita: ' . $berita->judul)

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <a href="{{ $backRouteUrl }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Daftar Berita</a>
    </div>
    <form action="{{ $formActionUrl }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.berita_CRUD._form', [
        'berita' => $berita,
        'tenant' => $tenant,
        'kategoris' => $kategoris,
        'kecamatans' => $kecamatans,
        'perangkatDaerahs' => $perangkatDaerahs,
        'backRouteUrl' => $backRouteUrl
        ])
    </form>
</div>
@endsection

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

    body.fading-out #page-content {
        animation: fadeOut 0.5s ease-out forwards;
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
</style>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');
        links.forEach(link => {
            link.addEventListener('click', (event) => {
                if (link.closest('form[onsubmit]')) { return; }
                event.preventDefault();
                document.body.classList.add('fading-out');
                setTimeout(() => { window.location.href = link.href; }, 500);
            });
        });
        document.querySelector('#page-content').style.animation = 'fadeIn 0.5s ease-out forwards';
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) { document.body.classList.remove('fading-out'); }
        });
    });
</script>
@endpush