@extends('layouts.app')

@php
$hasTenant = isset($tenant);
$pageTitle = 'Kelola Agenda';
$routePrefix = 'admin.kabupaten.agenda'; // Default untuk Kabupaten
$routeParameters = [];

if ($tenant instanceof \App\Models\PerangkatDaerah) {
$routePrefix = 'admin.perangkat-daerah.agenda';
$routeParameters = ['perangkatDaerah' => $tenant->slug];
$pageTitle .= ' ' . $tenant->name;
} elseif ($tenant instanceof \App\Models\Kecamatan) {
$routePrefix = 'admin.kecamatan.agenda';
$routeParameters = ['kecamatan' => $tenant->slug];
$pageTitle .= ' Kecamatan ' . $tenant->name;
}
$createUrl = route($routePrefix . '.create', $routeParameters);
@endphp

@section('title', 'Kelola Agenda')

@section('content')
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">{{ $pageTitle }}</h1>
        @can('create', \App\Models\Agenda::class)
        <a href="{{ $createUrl }}"
            class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors shadow-md hover:shadow-lg">
            <i class="fas fa-plus mr-2"></i>
            <span>Tambah Agenda</span>
        </a>
        @endcan
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Judul
                            Agenda</th>
                        @if(!$hasTenant)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Pemilik</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Tanggal Selesai</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($agendas as $agenda)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ Str::limit($agenda->judul, 45) }}</div>
                        </td>
                        @if(!$hasTenant)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $agenda->kecamatan->name ??
                            $agenda->perangkatDaerah->name ?? 'Kabupaten' }}</td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{
                            \Carbon\Carbon::parse($agenda->tanggal_mulai)->isoFormat('D MMMM YYYY') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $agenda->tanggal_selesai ?
                            \Carbon\Carbon::parse($agenda->tanggal_selesai)->isoFormat('D MMMM YYYY') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-4">
                                @php
                                $itemTenant = $agenda->kecamatan ?? $agenda->perangkatDaerah;
                                $itemRoutePrefix = 'admin.kabupaten.agenda';
                                $itemRouteParams = [];
                                if ($itemTenant instanceof \App\Models\Kecamatan) {
                                $itemRoutePrefix = 'admin.kecamatan.agenda';
                                $itemRouteParams = ['kecamatan' => $itemTenant->slug];
                                } elseif ($itemTenant instanceof \App\Models\PerangkatDaerah) {
                                $itemRoutePrefix = 'admin.perangkat-daerah.agenda';
                                $itemRouteParams = ['perangkatDaerah' => $itemTenant->slug];
                                }
                                @endphp
                                @can('update', $agenda)
                                <a href="{{ route($itemRoutePrefix . '.edit', array_merge($itemRouteParams, ['agenda' => $agenda])) }}"
                                    class="font-semibold text-indigo-600 hover:text-indigo-900">Edit</a>
                                @endcan
                                @can('delete', $agenda)
                                <form
                                    action="{{ route($itemRoutePrefix . '.destroy', array_merge($itemRouteParams, ['agenda' => $agenda])) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-semibold text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $hasTenant ? 4 : 5 }}" class="px-6 py-12 text-center text-gray-500">Belum ada
                            data agenda yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($agendas->hasPages())
        <div class="p-4 bg-gray-50 border-t border-gray-200">
            {{ $agendas->links() }}
        </div>
        @endif
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