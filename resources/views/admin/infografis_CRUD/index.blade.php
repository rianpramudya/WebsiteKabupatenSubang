@extends('layouts.app')

@php
// =================================================================
// LOGIKA CERDAS UNTUK SEMUA PERAN
// =================================================================
// Logika ini sekarang bisa menangani 3 kondisi:
// 1. Jika ada tenant dan merupakan Kecamatan
// 2. Jika ada tenant dan merupakan Perangkat Daerah
// 3. Jika tidak ada tenant (null), berarti ini adalah level Kabupaten
// =================================================================
if ($tenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
// Tentukan awalan nama rute yang benar berdasarkan tenant
$routePrefix = $isKecamatan ? 'admin.kecamatan.profil.infografis' : 'admin.perangkat-daerah.profil.infografis';
} else {
// Atur awalan rute untuk level Kabupaten
$routePrefix = 'admin.kabupaten.infografis';
}
@endphp

{{-- [DIPERBAIKI] Judul halaman sekarang aman dari error 'null' --}}
@section('title', 'Kelola Infografis - ' . ($tenant ? $tenant->name : 'Kabupaten'))

@section('content')
<div id="page-content" class="container mx-auto px-4 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1E4E7C]">Kelola Infografis</h1>
            {{-- [DIPERBAIKI] Teks 'Untuk:' sekarang aman dari error 'null' --}}
            <p class="text-gray-600 mt-1">Untuk: {{ $tenant ? $tenant->name : 'Kabupaten' }}</p>
        </div>

        {{-- [DIPERBAIKI] Link 'Tambah' sekarang dinamis dan aman --}}
        <a href="{{ $tenant ? route($routePrefix . '.create', $tenant->slug) : route($routePrefix . '.create') }}"
            class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center mt-4 sm:mt-0">
            <i class="fas fa-plus mr-2"></i> Tambah Infografis
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
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Gambar</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Terbit</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($infografis as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}"
                                class="h-16 w-16 object-cover rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->judul }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-4">
                                {{-- [DIPERBAIKI] Link 'Edit' dinamis dan aman --}}
                                <a href="{{ $tenant ? route($routePrefix . '.edit', [$tenant->slug, $item->id]) : route($routePrefix . '.edit', $item->id) }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800">Edit</a>

                                {{-- [DIPERBAIKI] Form 'Hapus' dinamis dan aman --}}
                                <form
                                    action="{{ $tenant ? route($routePrefix . '.destroy', [$tenant->slug, $item->id]) : route($routePrefix . '.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menghapus infografis ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-semibold text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            Belum ada data infografis untuk wilayah ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($infografis->hasPages())
        <div class="p-4">
            {{ $infografis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

{{-- [DIPERBAIKI] Kode Style dan Script dimasukkan ke dalam @push agar sesuai standar Laravel --}}
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
@endpush

@push('scripts')
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
@endpush