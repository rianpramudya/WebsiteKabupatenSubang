@php
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
$crudRoutePrefix = $baseRouteName . 'hotel';
$parentRoute = $baseRouteName . 'index';
@endphp

@extends('layouts.app')

@section('title', 'Kelola Hotel - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <a href="{{ route($parentRoute, $routeParameters) }}" class="text-gray-600 hover:text-gray-900">&larr;
                Kembali ke Menu Wisata</a>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Hotel untuk {{ $tenantName }}</h1>
        </div>
        <a href="{{ route($crudRoutePrefix . '.create', $routeParameters) }}"
            class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors mt-2 sm:mt-0">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </a>
    </div>
    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Hotel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alamat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bintang</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($hotels as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit(strip_tags($item->alamat), 60) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            @if($item->bintang)
                            <span class="text-yellow-500">{{ str_repeat('★', $item->bintang) }}</span>
                            <span class="text-gray-400">{{ str_repeat('★', 5 - $item->bintang) }}</span>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route($crudRoutePrefix . '.edit', array_merge($routeParameters, ['hotel' => $item->id])) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                            <form
                                action="{{ route($crudRoutePrefix . '.destroy', array_merge($routeParameters, ['hotel' => $item->id])) }}"
                                method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data hotel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');
            links.forEach(link => {
                link.addEventListener('click', (event) => {
                    if (link.closest('form[onsubmit]')) { return; }
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