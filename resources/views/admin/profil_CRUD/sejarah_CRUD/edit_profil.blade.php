@extends('layouts.app')

@php
    // Logika routing multi-tenant
    if ($tenant instanceof \App\Models\Kecamatan && $tenant->slug !== 'kabupaten-subang') {
        $baseRouteName = 'admin.kecamatan.';
        $routeParameters = ['kecamatan' => $tenant->slug];
    } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
        $baseRouteName = 'admin.perangkat-daerah.';
        $routeParameters = ['perangkatDaerah' => $tenant->slug];
    } else {
        $baseRouteName = 'admin.kabupaten.';
        $routeParameters = [];
    }
@endphp

@section('title', 'Edit Sejarah & Lambang - ' . $tenant->name)

{{-- ================================================================= --}}
{{-- Menambahkan Aset Trix (CSS) dan Custom Style --}}
{{-- ================================================================= --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        .trix-content {
            min-height: 160px;
            border-color: #d1d5db;
            border-radius: 0.75rem;
            padding: 1rem;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: all .2s ease;
        }

        .trix-content:focus {
            border-color: #1E4E7C;
            box-shadow: 0 0 0 2px #1E4E7C33;
        }

        .form-section {
            background: #f9fafb;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }

        label {
            font-weight: 600;
            color: #374151;
        }

        input[type="file"] {
            background-color: #f9fafb;
        }

        button, .btn {
            transition: all .2s ease-in-out;
        }
    </style>
@endpush

@section('content')
<div id="page-content" class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-extrabold text-[#1E4E7C] mb-8">Edit Sejarah Awal & Lambang</h1>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        {{-- ==== FORM UTAMA ==== --}}
        <form action="{{ route($baseRouteName . 'profil.sejarah.updateProfil', $routeParameters) }}" 
              method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Sejarah Awal --}}
            <div class="form-section">
                <label for="sejarah" class="block mb-2">Deskripsi Sejarah Awal</label>
                <input id="sejarah" type="hidden" name="sejarah" value="{{ old('sejarah', $tenant->sejarah) }}">
                <trix-editor input="sejarah" class="trix-content"></trix-editor>
            </div>

            {{-- Arti Lambang --}}
            <div class="form-section">
                <label for="arti_lambang" class="block mb-2">Arti Lambang</label>
                <input id="arti_lambang" type="hidden" name="arti_lambang" value="{{ old('arti_lambang', $tenant->arti_lambang) }}">
                <trix-editor input="arti_lambang" class="trix-content"></trix-editor>
            </div>

            {{-- Logo --}}
            <div class="form-section">
                <label for="logo" class="block mb-2">Ganti Lambang/Logo</label>
                <input type="file" name="logo" id="logo" class="block w-full border border-gray-300 rounded-lg px-3 py-2">
                @if($tenant->logo)
                    <div class="mt-3">
                        <p class="text-sm text-gray-600">Lambang Saat Ini:</p>
                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo" 
                             class="w-28 h-28 mt-2 border rounded-lg p-1 object-contain shadow">
                        <button type="submit" form="delete-logo-form" 
                                class="text-sm text-red-600 hover:text-red-800 font-medium mt-2 inline-block"
                                onclick="return confirm('Anda yakin ingin menghapus logo ini?');">
                            Hapus Logo
                        </button>
                    </div>
                @endif
            </div>

            {{-- Gambar Sejarah --}}
            <div class="form-section">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Gambar-gambar Sejarah</h3>
                <p class="text-sm text-gray-500 mb-6">Kosongkan jika tidak ingin mengubah gambar.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach([1,2,3] as $i)
                        <div>
                            <label for="sejarah_img_{{ $i }}" class="block mb-2">Gambar Sejarah {{ $i }}</label>
                            <input type="file" name="sejarah_img_{{ $i }}" id="sejarah_img_{{ $i }}" 
                                   class="block w-full border border-gray-300 rounded-lg px-3 py-2">
                            @php $imgField = "sejarah_img_$i"; @endphp
                            @if($tenant->$imgField)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-600">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $tenant->$imgField) }}" 
                                         class="mt-2 w-full h-36 object-cover rounded-lg shadow">
                                    <button type="submit" form="delete-{{ $imgField }}-form" 
                                            class="w-full text-center text-sm font-semibold text-red-600 hover:text-red-800 mt-2"
                                            onclick="return confirm('Anda yakin ingin menghapus gambar ini?');">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus Gambar
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end pt-6 border-t border-gray-200 space-x-4">
                <a href="{{ route($baseRouteName . 'profil.sejarah.index', $routeParameters) }}" 
                   class="btn bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg">
                    Batal
                </a>
                <button type="submit" 
                        class="btn bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-6 rounded-lg shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        {{-- ==== FORM-FORM HAPUS ==== --}}
        @if($tenant->logo)
            <form id="delete-logo-form" action="{{ route($baseRouteName . 'profil.sejarah.destroyImage', $routeParameters) }}" method="POST" class="hidden">
                @csrf @method('DELETE')
                <input type="hidden" name="image_field" value="logo">
            </form>
        @endif
        @foreach([1,2,3] as $i)
            @php $imgField = "sejarah_img_$i"; @endphp
            @if($tenant->$imgField)
                <form id="delete-{{ $imgField }}-form" action="{{ route($baseRouteName . 'profil.sejarah.destroyImage', $routeParameters) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                    <input type="hidden" name="image_field" value="{{ $imgField }}">
                </form>
            @endif
        @endforeach
    </div>
</div>
@endsection

{{-- ================================================================= --}}
{{-- Aset Trix (JS) --}}
{{-- ================================================================= --}}
@push('scripts')
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush