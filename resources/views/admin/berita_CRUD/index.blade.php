@php
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
@endphp

@extends('layouts.app')
@section('title', 'Manajemen Berita - ' . $tenantName)

@section('content')
<div id="page-content" class="container mx-auto px-6 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1E4E7C]">Manajemen Berita</h1>
            <h2 class="text-xl text-gray-600 font-semibold">Untuk: Konten {{ $tenantName }}</h2>
        </div>
        @can('create', \App\Models\Berita::class)
        <a href="{{ route($routePrefix . '.create', $routeParameters) }}"
            class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center mt-4 sm:mt-0">
            <i class="fas fa-plus mr-2"></i> Tambah Berita Baru
        </a>
        @endcan
    </div>

    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Judul</th>
                    @if(!$tenant)
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Pemilik Konten</th>
                    @endif
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Kategori</th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tanggal Terbit</th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($beritas as $itemBerita)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">

                        <a href="{{ route($routePrefix . '.show', array_merge($routeParameters, ['berita' => $itemBerita])) }}"
                            class="text-gray-900 font-semibold whitespace-no-wrap hover:text-[#1E4E7C] transition-colors">
                            {{ $itemBerita->judul }}
                        </a>
                    </td>
                    @if(!$tenant)
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $itemBerita->kecamatan->name ??
                            ($itemBerita->perangkatDaerah->name ?? 'Kabupaten') }}</p>
                    </td>
                    @endif
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $itemBerita->kategori->nama ?? 'N/A' }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{
                            \Carbon\Carbon::parse($itemBerita->published_at)->isoFormat('D MMMM YYYY') }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center space-x-2">
                            @can('update', $itemBerita)
                            <a href="{{ route($routePrefix . '.edit', array_merge($routeParameters, ['berita' => $itemBerita])) }}"
                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            @endcan
                            @can('delete', $itemBerita)
                            <form
                                action="{{ route($routePrefix . '.destroy', array_merge($routeParameters, ['berita' => $itemBerita])) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $tenant ? 4 : 5 }}" class="text-center py-10 text-gray-500">Tidak ada berita yang
                        ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($beritas->hasPages())
    <div class="mt-8">{{ $beritas->links() }}</div>
    @endif
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