@extends('layouts.app')

@php
$tenant = $kecamatan ?? null; // Tetap gunakan variabel tenant Anda
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;

$baseRouteName = $isKecamatan ? 'admin.kecamatan.wisata.' : 'admin.kabupaten.wisata.';
$routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : [];
@endphp

@section('title', 'Kelola Wisata - ' . ($tenant ? $tenant->name : 'Kabupaten'))

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Konten Wisata</h1>

        @if ($tenant)
        <p class="text-gray-600 mt-1">Anda sedang mengelola konten untuk Kecamatan <span class="font-semibold">{{
                $tenant->name }}</span></p>
        @else
        <p class="text-gray-600 mt-1">Anda sedang mengelola konten wisata untuk tingkat <strong>Kabupaten</strong>.</p>
        @endif
    </div>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 md-grid-cols-2 lg:grid-cols-2 gap-6">

        <a href="{{ route($baseRouteName . 'budaya.index', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-full"><i class="fas fa-palette fa-lg text-indigo-600"></i></div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Seni dan Budaya</h2>
                    <p class="mt-2 text-gray-600 text-sm">Kelola data kesenian dan kebudayaan khas.</p>
                </div>
            </div>
        </a>

        <a href="{{ route($baseRouteName . 'objek-wisata.index', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-teal-100 rounded-full"><i class="fas fa-map-signs fa-lg text-teal-600"></i></div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Objek Wisata</h2>
                    <p class="mt-2 text-gray-600 text-sm">Kelola data tempat-tempat wisata alam dan buatan.</p>
                </div>
            </div>
        </a>

        <a href="{{ route($baseRouteName . 'hotel.index', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-amber-100 rounded-full"><i class="fas fa-concierge-bell fa-lg text-amber-600"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Hotel</h2>
                    <p class="mt-2 text-gray-600 text-sm">Kelola data hotel dan penginapan.</p>
                </div>
            </div>
        </a>

        <a href="{{ route($baseRouteName . 'rumah-makan.index', $routeParameters) }}"
            class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-rose-100 rounded-full"><i class="fas fa-utensils fa-lg text-rose-600"></i></div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-700">Rumah Makan</h2>
                    <p class="mt-2 text-gray-600 text-sm">Kelola data tempat kuliner dan restoran.</p>
                </div>
            </div>
        </a>

    </div>
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