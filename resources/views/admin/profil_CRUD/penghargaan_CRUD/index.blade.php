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

@section('title', 'Kelola Penghargaan - ' . $tenantName)
@section('content')
    <div id="page-content" class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Daftar Penghargaan</h1>

            <a href="{{ route($baseRouteName . 'profil.penghargaan.create', $routeParameters) }}"
                class="bg-[#1E4E7C] hover:brightness-90 text-white rounded-lg font-bold py-2 px-4">
                <i class="fas fa-plus mr-2"></i>Tambah Penghargaan</a>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Penghargaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($penghargaans as $item)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $item->nama_penghargaan }}</td>
                            <td class="px-6 py-4">{{ $item->tahun }}</td>
                            <td class="px-6 py-4">{{ $item->tingkat }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route($baseRouteName . 'profil.penghargaan.edit', array_merge($routeParameters, ['penghargaan' => $item->id])) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route($baseRouteName . 'profil.penghargaan.destroy', array_merge($routeParameters, ['penghargaan' => $item->id])) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data penghargaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $penghargaans->links() }}</div>
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
