@extends('layouts.app')

@php
$tenant = $kecamatan ?? $perangkatDaerah;
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;

if ($tenant) {
$tenantType = $isKecamatan ? 'Kecamatan' : 'Perangkat Daerah';
} else {
$tenantType = 'Kabupaten';
}
@endphp

@section('title', 'Kelola Pemerintahan - ' . ($tenant ? $tenant->name : 'Kabupaten'))

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Konten Pemerintahan</h1>

        @if ($tenant)
        <p class="text-gray-600 mt-1">Anda sedang mengelola konten untuk {{ $tenantType }} <span
                class="font-semibold">{{ $tenant->name }}</span></p>
        @else
        <p class="text-gray-600 mt-1">Anda sedang mengelola konten pemerintahan untuk tingkat
            <strong>Kabupaten</strong>.
        </p>
        @endif
    </div>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <p class="font-semibold">Sukses!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="
            {{ $tenant
                ? route(($isKecamatan ? 'admin.kecamatan.pemerintahan' : 'admin.perangkat-daerah.pemerintahan') . '.pejabats.index', $tenant->slug)
                : route('admin.kabupaten.pemerintahan.pejabats.index') }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full"><i class="fas fa-sitemap fa-lg text-blue-600"></i></div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Struktur Pemerintahan</h2>
                    <p class="mt-3 text-gray-600 text-sm">Kelola data pejabat, staf, dan urutan jabatan.</p>
                </div>
            </div>
        </a>

        <a href="
            {{ $tenant
                ? route(($isKecamatan ? 'admin.kecamatan.pemerintahan' : 'admin.perangkat-daerah.pemerintahan') . '.peran-program.index', $tenant->slug)
                : route('admin.kabupaten.pemerintahan.peran-program.index') }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full"><i class="fas fa-tasks fa-lg text-green-600"></i></div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Peran dan Program</h2>
                    <p class="mt-3 text-gray-600 text-sm">Kelola data tugas pokok dan fungsi (Tupoksi).</p>
                </div>
            </div>
        </a>

        <a href="
            {{ $tenant
                ? route(($isKecamatan ? 'admin.kecamatan.pemerintahan' : 'admin.perangkat-daerah.pemerintahan') . '.wilayah-administrasi.index', $tenant->slug)
                : route('admin.kabupaten.pemerintahan.wilayah-administrasi.index') }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full"><i class="fas fa-map-signs fa-lg text-yellow-600"></i></div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Wilayah Administrasi</h2>

                    <p class="mt-3 text-gray-600 text-sm">
                        {{ $tenant ? 'Kelola data nama desa atau kelurahan di kecamatan.' : 'Kelola data kecamatan di
                        kabupaten.' }}
                    </p>
                </div>
            </div>
        </a>

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

    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (document.startViewTransition) {
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href*="javascript:void(0)"])');
            links.forEach(link => {
                link.addEventListener('click', (event) => {
                    if (link.closest('form') || link.getAttribute('role') === 'button') {
                        return;
                    }
                    event.preventDefault();
                    const toUrl = new URL(link.href);

                    if (location.origin === toUrl.origin) {
                        document.startViewTransition(() => {
                            window.location.href = link.href;
                        });
                    } else {
                        window.location.href = link.href;
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection