@extends('layouts.app')

@php
    if ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
        $baseRouteName = 'admin.kecamatan.';
        $routeParameters = ['kecamatan' => $tenant->slug];
    } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
        $baseRouteName = 'admin.perangkat-daerah.';
        $routeParameters = ['perangkatDaerah' => $tenant->slug];
    } else {
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = []; // Rute kabupaten tidak butuh parameter
    }
@endphp

@section('title', 'Kelola Sejarah - ' . $tenant->name)

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">

    <div class="mb-8 p-6 bg-white shadow-lg rounded-xl border border-gray-200">
        <div class="flex justify-between items-center mb-4 pb-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Sejarah Awal & Lambang</h2>
            <a href="{{ route($baseRouteName . 'profil.sejarah.editProfil', $routeParameters) }}" class="bg-[#1E4E7C] hover:bg-blue-800 text-white rounded-lg font-bold py-2 px-4 transition-colors duration-300 shadow-sm flex items-center">
                <i class="fas fa-pencil-alt mr-2"></i> Edit
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
            <div class="md:col-span-2">
                <h3 class="text-xl font-semibold text-gray-700">Sejarah Awal</h3>
                <div class="prose max-w-none text-gray-600 mt-2">
                    {!! $tenant->sejarah ?: '<p class="text-gray-400 italic">Deskripsi sejarah awal belum diisi.</p>' !!}
                </div>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-700">Arti Lambang</h3>
                <div class="mt-2 text-gray-600">
                    @if($tenant->logo)
                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo" class="w-24 h-24 mb-2 object-contain border p-1 rounded-md bg-gray-50">
                    @endif
                    <div class="prose-sm max-w-none">
                         {!! $tenant->arti_lambang ?: '<p class="text-gray-400 italic">Deskripsi arti lambang belum diisi.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Timeline Sejarah</h1>
        <a href="{{ route($baseRouteName . 'profil.sejarah.create', $routeParameters) }}" class="bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold py-2 px-4 transition-colors duration-300 shadow-sm flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Timeline
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($sejarahs as $item)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->urutan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->tahun }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->judul }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route($baseRouteName . 'profil.sejarah.edit', array_merge($routeParameters, ['sejarah' => $item->id])) }}" class="text-indigo-600 hover:text-indigo-800 mr-3 font-semibold">Edit</a>
                        <form action="{{ route($baseRouteName . 'profil.sejarah.destroy', array_merge($routeParameters, ['sejarah' => $item->id])) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data timeline sejarah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $sejarahs->links() }}
    </div>
</div>
@endsection
