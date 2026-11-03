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

    $crudRoutePrefix = $baseRouteName . 'pejabats';
@endphp

@extends('layouts.app')

@section('title', 'Kelola Struktur Pemerintahan - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Struktur Pemerintahan {{ $tenantName }}</h1>

        <a href="{{ route($crudRoutePrefix . '.create', $routeParameters) }}"
            class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm md:text-base">
            <i class="fas fa-plus mr-2"></i>Tambah Pejabat
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pejabat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pejabats as $pejabat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pejabat->urutan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $pejabat->foto ? asset('storage/' . $pejabat->foto) : 'https://placehold.co/100x100/e2e8f0/64748b?text=Foto' }}"
                                alt="Foto {{ $pejabat->nama }}" class="h-12 w-12 rounded-full object-cover">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pejabat->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pejabat->jabatan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                            <a href="{{ route($crudRoutePrefix . '.edit', array_merge($routeParameters, ['pejabat' => $pejabat->id])) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                            <form action="{{ route($crudRoutePrefix . '.destroy', array_merge($routeParameters, ['pejabat' => $pejabat->id])) }}"
                                method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data pejabat.</td>
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
                if (link.closest('form[onsubmit]')) {
                    return;
                }
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