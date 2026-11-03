@extends('layouts.app')

@php
if ($tenant) {
$isKecamatan = $tenant instanceof \App\Models\Kecamatan;
$routePrefix = $isKecamatan ? 'admin.kecamatan.laporan-keuangan' : 'admin.perangkat-daerah.laporan-keuangan';
$tenantType = $isKecamatan ? 'Kecamatan' : 'Perangkat Daerah';
} else {
$routePrefix = 'admin.kabupaten.laporan-keuangan'; // Rute untuk level Kabupaten
$tenantType = 'Kabupaten';
}
@endphp

@section('title', 'Kelola Laporan Keuangan - ' . ($tenant ? $tenant->name : 'Kabupaten'))

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <h1 class="text-3xl font-bold text-[#1E4E7C]">

            Kelola Laporan Keuangan <span>{{ $tenant ? $tenant->name : 'Kabupaten' }}</span>
        </h1>

        <a href="{{ $tenant ? route($routePrefix . '.create', $tenant->slug) : route($routePrefix . '.create') }}"
            class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors shadow-md hover:shadow-lg mt-4 sm:mt-0">
            <i class="fas fa-plus mr-2"></i>
            Tambah Laporan
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <p class="font-semibold">Sukses!</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Judul
                            Laporan</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jenis
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tahun
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Tanggal Upload</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($laporanKeuangans as $laporan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration +
                            ($laporanKeuangans->firstItem() ? $laporanKeuangans->firstItem() - 1 : 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ Str::limit($laporan->judul_laporan, 50)
                                }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->jenis_laporan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->tahun }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{
                            \Carbon\Carbon::parse($laporan->created_at)->isoFormat('D MMMM YYYY') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-4">
                                <a href="{{ asset('storage/' . $laporan->file_url) }}" target="_blank"
                                    class="font-semibold text-gray-600 hover:text-gray-900" title="Lihat">Lihat</a>

                                <a href="{{ $tenant ? route($routePrefix . '.edit', [$tenant->slug, $laporan->id]) : route($routePrefix . '.edit', $laporan->id) }}"
                                    class="font-semibold text-indigo-600 hover:text-indigo-900" title="Edit">Edit</a>

                                <form
                                    action="{{ $tenant ? route($routePrefix . '.destroy', [$tenant->slug, $laporan->id]) : route($routePrefix . '.destroy', $laporan->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold text-red-600 hover:text-red-900"
                                        title="Hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open fa-3x text-gray-400 mb-4"></i>
                                <p class="text-lg font-semibold text-gray-600">Data Tidak Ditemukan</p>

                                <p class="text-sm text-gray-500 mt-1">Belum ada data laporan keuangan yang tersedia
                                    untuk {{ strtolower($tenantType) }} ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($laporanKeuangans->hasPages())
        <div class="p-4 bg-gray-50 border-t border-gray-200">
            {{ $laporanKeuangans->links() }}
        </div>
        @endif
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