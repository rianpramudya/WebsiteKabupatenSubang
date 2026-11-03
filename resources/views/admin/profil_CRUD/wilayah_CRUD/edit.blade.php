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

@extends('layouts.app')
@section('title', 'Edit Wilayah - ' . $tenant->name)

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    .trix-button-group {
        background-color: #f9fafb;
    }

    trix-editor {
        background-color: white;
        border-color: #D1D5DB;
        min-height: 200px;
    }

    trix-editor:focus {
        border-color: #1E4E7C !important;
        box-shadow: 0 0 0 1px #1E4E7C !important;
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
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Informasi Wilayah: {{ $tenant->name }}</h1>
    <div class="bg-white p-8 rounded-lg shadow-md">

        <form action="{{ route($baseRouteName . 'profil.wilayah.update', $routeParameters) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">

                <div>
                    <label for="letak_geografis" class="block text-sm font-medium text-gray-700 mb-1">Letak
                        Geografis</label>

                    <input id="letak_geografis" type="hidden" name="letak_geografis"
                        value="{{ old('letak_geografis', $tenant->letak_geografis) }}">
                    <trix-editor input="letak_geografis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </trix-editor>
                </div>

                <div>
                    <label for="iklim" class="block text-sm font-medium text-gray-700 mb-1">Iklim</label>

                    <input id="iklim" type="hidden" name="iklim" value="{{ old('iklim', $tenant->iklim) }}">
                    <trix-editor input="iklim" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </trix-editor>
                </div>

                <div>
                    <label for="demografi" class="block text-sm font-medium text-gray-700 mb-1">Demografi</label>

                    <input id="demografi" type="hidden" name="demografi"
                        value="{{ old('demografi', $tenant->demografi) }}">
                    <trix-editor input="demografi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </trix-editor>
                </div>

                <div>
                    <label for="topografi" class="block text-sm font-medium text-gray-700 mb-1">Topografi</label>

                    <input id="topografi" type="hidden" name="topografi"
                        value="{{ old('topografi', $tenant->topografi) }}">
                    <trix-editor input="topografi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </trix-editor>
                </div>

            </div>
            <div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">

                <a href="{{ route($baseRouteName . 'profil.index', $routeParameters) }}"
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