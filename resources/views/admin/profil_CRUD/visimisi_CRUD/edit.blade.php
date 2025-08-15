@extends('layouts.app')

@php
// [PERBAIKAN] Logika ini sekarang menangani 3 konteks dengan benar
if ($tenant instanceof \App\Models\PerangkatDaerah) {
$routePrefix = 'admin.perangkat-daerah.profil';
$routeParameters = ['perangkatDaerah' => $tenant->slug];
} elseif ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
$routePrefix = 'admin.kecamatan.profil';
$routeParameters = ['kecamatan' => $tenant->slug];
} else {
// Ini adalah konteks Kabupaten untuk Superadmin
$routePrefix = 'admin.kabupaten.profil';
$routeParameters = []; // Rute kabupaten tidak butuh parameter
}
@endphp

@section('title', 'Edit Visi & Misi - ' . $tenant->name)

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }

    .trix-content {
        min-height: 150px;
        border-color: #d1d5db;
        border-radius: 0.375rem;
        padding: 0.75rem;
        background-color: white;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .trix-content:focus {
        border-color: #1E4E7C;
        box-shadow: 0 0 0 1px #1E4E7C;
    }

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

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Visi & Misi: {{ $tenant->name }}</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">

        <form action="{{ route($routePrefix . '.visimisi.update', $routeParameters) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="visi" class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                    <input id="visi" type="hidden" name="visi" value="{{ old('visi', $tenant->visi) }}">
                    <trix-editor input="visi" class="trix-content"></trix-editor>
                </div>

                <div>
                    <label for="misi" class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                    <input id="misi" type="hidden" name="misi" value="{{ old('misi', $tenant->misi) }}">
                    <trix-editor input="misi" class="trix-content"></trix-editor>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">
                <a href="{{ route($routePrefix . '.index', $routeParameters) }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors">Batal</a>
                <button type="submit"
                    class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush