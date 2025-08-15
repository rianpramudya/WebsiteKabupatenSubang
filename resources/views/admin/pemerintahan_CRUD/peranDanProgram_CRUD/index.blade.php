@php
    // [PERBAIKAN] Blok ini dipindahkan ke baris paling atas dan disempurnakan
    if ($tenant) {
        $isKecamatan = $tenant instanceof \App\Models\Kecamatan;
        $baseRouteName = $isKecamatan ? 'admin.kecamatan.pemerintahan.' : 'admin.perangkat-daerah.pemerintahan.';
        $routeParameters = $isKecamatan ? ['kecamatan' => $tenant->slug] : ['perangkatDaerah' => $tenant->slug];
        $tenantName = $tenant->name;
    } else {
        // Ini untuk level Kabupaten
        $baseRouteName = 'admin.kabupaten.pemerintahan.';
        $routeParameters = [];
        $tenantName = 'Kabupaten';
    }
    // Variabel spesifik untuk CRUD Peran & Program
    $crudRoutePrefix = $baseRouteName . 'peran-program';
@endphp

@extends('layouts.app')

{{-- [FIXED] Sekarang menggunakan $tenantName yang sudah pasti ada --}}
@section('title', 'Kelola Peran dan Program - ' . $tenantName)

@section('content')
    <div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            {{-- [FIXED] Judul sekarang menggunakan $tenantName --}}
            <h1 class="text-2xl font-bold text-gray-800">Peran dan Program (Tupoksi) {{ $tenantName }}</h1>
            {{-- [FIXED] Tautan sekarang menggunakan variabel yang aman --}}
            <a href="{{ route($crudRoutePrefix . '.create', $routeParameters) }}"
               class="bg-[#1E4E7C] hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-colors">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($peranDanPrograms as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->urutan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->judul }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit(str_replace('&nbsp;', ' ', strip_tags($item->deskripsi)), 100) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    {{-- [FIXED] Tautan sekarang menggunakan variabel yang aman --}}
                                    <a href="{{ route($crudRoutePrefix . '.edit', array_merge($routeParameters, ['peranProgram' => $item->id])) }}"
                                       class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <form
                                        action="{{ route($crudRoutePrefix . '.destroy', array_merge($routeParameters, ['peranProgram' => $item->id])) }}"
                                        method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data peran dan program.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
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
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');

            links.forEach(link => {
                link.addEventListener('click', (event) => {
                    // Cek jika link berada di dalam form atau tabel, jangan lakukan fade
                    if (link.closest('form') || link.closest('td')) {
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
