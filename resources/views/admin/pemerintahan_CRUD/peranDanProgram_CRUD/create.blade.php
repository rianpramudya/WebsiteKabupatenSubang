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
@section('title', 'Tambah Peran & Program - ' . $tenantName)

@push('styles')
{{-- Memuat CSS untuk Trix Editor --}}
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-editor {
        background-color: white;
        border-color: #D1D5DB;
        min-height: 250px;
    }

    trix-editor:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 1px #4f46e5 !important;
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
<div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- [FIXED] Judul sekarang menggunakan $tenantName --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Peran & Program Baru untuk {{ $tenantName }}</h1>
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
        {{-- [FIXED] Rute store sekarang menggunakan variabel yang aman --}}
        <form action="{{ route($crudRoutePrefix . '.store', $routeParameters) }}" method="POST">

            {{-- Mengirim variabel yang dibutuhkan ke form partial --}}
            @include('admin.pemerintahan_CRUD.peranDanProgram_CRUD._form', [
            'peranProgram' => new \App\Models\PeranDanProgram,
            'tenant' => $tenant,
            'routePrefix' => $crudRoutePrefix,
            'routeParameters' => $routeParameters
            ])

        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- Memuat JavaScript untuk Trix Editor --}}
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

{{-- Script untuk animasi fade out saat pindah halaman --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(form a)').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    document.body.style.animation = 'fadeOut 0.5s ease-out forwards';
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 500);
                });
            });
        });
        
        // CSS untuk animasi fadeOut ditambahkan melalui script agar lebih terpusat
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
            body { animation: fadeIn 0.5s ease-out forwards; }
        `;
        document.head.append(style);
</script>
@endpush