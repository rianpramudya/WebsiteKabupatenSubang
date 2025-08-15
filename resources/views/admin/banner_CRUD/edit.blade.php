@php
    // Tentukan tipe tenant untuk digunakan di seluruh view
    $tenantType = $tenant instanceof \App\Models\Kecamatan ? 'Kecamatan' : 'Perangkat Daerah';
    $updateRoute = $tenant instanceof \App\Models\Kecamatan
        ? route('admin.kecamatan.banner.update', $tenant->slug)
        : route('admin.perangkat-daerah.banner.update', $tenant->slug);
    $destroyRoute = $tenant instanceof \App\Models\Kecamatan
        ? route('admin.kecamatan.banner.destroy', $tenant->slug)
        : route('admin.perangkat-daerah.banner.destroy', $tenant->slug);
@endphp

@extends('layouts.app')
@section('title', 'Kelola Banner ' . $tenantType . ' ' . $tenant->name)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 leading-tight">Kelola Banner</h1>
            <p class="mt-1 text-lg text-gray-600">Anda sedang mengubah banner untuk {{ $tenantType }}:
                <span class="font-semibold text-gray-900">{{ $tenant->name }}</span>
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            {{-- Form utama dengan scope AlpineJS --}}
            <form x-data="bannerData()" action="{{ $updateRoute }}" method="POST"
                enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg relative">
                @csrf
                @method('PUT')

                {{-- Notifikasi --}}
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
                @endif
                @if ($errors->any() || session('error') || session('info'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                     <ul>
                        @if(session('error')) <li>{{ session('error') }}</li> @endif
                        @if(session('info')) <li>{{ session('info') }}</li> @endif
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                     </ul>
                </div>
                @endif

                <div class="space-y-8">
                    @include('admin.banner_CRUD._form', ['tenant' => $tenant])
                </div>

                @if($tenant->banner_url)
                <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-gray-900 bg-opacity-75"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                    
                    {{-- Konten Modal --}}
                    <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Hapus Banner</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus banner ini? Tindakan ini tidak dapat diurungkan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            {{-- PERBAIKAN 1: Logika klik diubah menjadi JavaScript standar --}}
                            <button @click="document.getElementById('delete-banner-form').submit()" type="button"
                                    {{-- PERBAIKAN 3: Efek Hover & Styling ditambahkan --}}
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">
                                Ya, Hapus
                            </button>
                            <button @click="showDeleteModal = false" type="button"
                                    {{-- PERBAIKAN 4: Efek Hover & Styling ditambahkan --}}
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors duration-300">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </form>

            @if($tenant->banner_url)
            {{-- PERBAIKAN 2: Form hapus diberi ID agar bisa dipanggil oleh tombol modal --}}
            <form id="delete-banner-form" action="{{ $destroyRoute }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts-footer')
{{-- Script AlpineJS tidak perlu diubah, sudah benar --}}
<script>
    function bannerData() {
        return {
            bannerType: '{{ old('banner_type', Str::startsWith($tenant->banner_url, 'http') ? 'youtube' : 'upload') }}',
            isDragging: false,
            showDeleteModal: false,
            newImagePreview: null,
            newVideoPreview: null,

            handleFileSelect(event) { this.setFile(event.target.files[0]); },
            handleDrop(event) {
                event.preventDefault(); this.isDragging = false;
                if (event.dataTransfer.files.length > 0) {
                    const file = event.dataTransfer.files[0];
                    document.getElementById('banner_file').files = event.dataTransfer.files;
                    this.setFile(file);
                }
            },
            setFile(file) {
                if (!file) return;
                this.newImagePreview = null; this.newVideoPreview = null;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => this.newImagePreview = e.target.result;
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/')) {
                    this.newVideoPreview = URL.createObjectURL(file);
                }
            }
        }
    }
</script>
@endpush