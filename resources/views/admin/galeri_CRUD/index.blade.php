@extends('layouts.app')
@section('title', 'Kelola Galeri')

@push('styles')
    <style>
        body { background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1E4E79; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #153859; }
    </style>
@endpush

@section('content')

    <div x-data="{ show: false, message: '', type: '' }" x-init="@if (session('success')) show = true; message = '{{ session('success') }}'; type = 'success'; setTimeout(() => show = false, 5000); @endif @if (session('error')) show = true; message = '{{ session('error') }}'; type = 'error'; setTimeout(() => show = false, 5000); @endif" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-5 right-5 z-50 p-4 rounded-xl shadow-lg text-white font-semibold backdrop-blur-sm" :class="{ 'bg-[#1E4E79]/90': type === 'success', 'bg-[#E20E0D]/90': type === 'error' }" style="display: none;">
        <div class="flex items-center">
            <i class="fas" :class="{ 'fa-check-circle': type === 'success', 'fa-times-circle': type === 'error' }"></i>
            <p class="ml-3" x-text="message"></p>
        </div>
    </div>

    <div id="page-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-[#1E4E79]">Galeri Media</h1>
                <p class="mt-1 text-sm text-gray-500">
                    @if(isset($kecamatan))
                        Kelola semua aset foto dan video untuk Kecamatan {{ $kecamatan->name }}.
                    @elseif(isset($perangkatDaerah))
                        Kelola semua aset foto dan video untuk {{ $perangkatDaerah->name }}.
                    @endif
                </p>
            </div>
            @can('create', \App\Models\Galeri::class)
                @php
                    $createRoute = '#';
                    if (isset($kecamatan)) {
                        $createRoute = route('admin.kecamatan.galeri.create', $kecamatan);
                    } elseif (isset($perangkatDaerah)) {
                        $createRoute = route('admin.perangkat-daerah.galeri.create', $perangkatDaerah);
                    }
                @endphp
                <a href="{{ $createRoute }}" class="mt-4 sm:mt-0 bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-5 rounded-lg flex items-center transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i> Tambah Media
                </a>
            @endcan
        </div>

        @php
            $fotoItems = $galeris->where('tipe', 'foto');
            $videoUploadItems = $galeris->where('tipe', 'video_upload');
            $videoYTItems = $galeris->where('tipe', 'video_yt');

            function renderEmptyState($icon, $type) {
                echo '<div class="text-center py-16 text-slate-500 bg-slate-50 rounded-lg"><i class="fas ' . $icon . ' fa-3x mb-4 text-slate-400"></i><p class="font-semibold text-lg">Belum Ada ' . $type . '</p><p class="text-sm">Silakan tambahkan ' . strtolower($type) . ' baru melalui tombol di atas.</p></div>';
            }
        @endphp

        <div class="bg-white p-6 rounded-lg shadow-md mb-10">
            <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-[#FCE405] pl-4 mb-6">Foto</h2>
            @if ($fotoItems->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($fotoItems as $item)
                        <div class="relative group aspect-square bg-gray-100 rounded-md overflow-hidden">
                            <img src="{{ asset('storage/' . $item->file_url) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover rounded-md">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                @can('delete', $item)
                                    @php
                                        $destroyRoute = '#';
                                        if (isset($kecamatan)) {
                                            $destroyRoute = route('admin.kecamatan.galeri.destroy', ['kecamatan' => $kecamatan, 'galeri' => $item]);
                                        } elseif (isset($perangkatDaerah)) {
                                            $destroyRoute = route('admin.perangkat-daerah.galeri.destroy', ['perangkatDaerah' => $perangkatDaerah, 'galeri' => $item]);
                                        }
                                    @endphp
                                    <form action="{{ $destroyRoute }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus media ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white hover:text-red-500 transform scale-150"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @php renderEmptyState('fa-camera-retro', 'Foto'); @endphp
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg mb-12">
            <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-[#FCE405] pl-4 mb-6">Video (Upload)</h2>
            @if ($videoUploadItems->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($videoUploadItems as $item)
                        <div class="relative group aspect-square bg-slate-800 rounded-lg overflow-hidden shadow-md">
                            @if($item->thumbnail_url)
                                <img src="{{ asset('storage/' . $item->thumbnail_url) }}" alt="Thumbnail for {{ $item->judul }}" class="w-full h-full object-cover">
                            @else
                                <video class="w-full h-full object-cover" preload="metadata" muted playsinline>
                                    <source src="{{ asset('storage/' . $item->file_url) }}#t=0.5" type="video/mp4">
                                </video>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 flex items-center justify-center transition-all duration-300">
                                <i class="fas fa-play-circle text-white text-4xl opacity-100 group-hover:opacity-0 transition-opacity"></i>
                                @can('delete', $item)
                                    @php
                                        $destroyRoute = '#';
                                        if (isset($kecamatan)) {
                                            $destroyRoute = route('admin.kecamatan.galeri.destroy', ['kecamatan' => $kecamatan, 'galeri' => $item]);
                                        } elseif (isset($perangkatDaerah)) {
                                            $destroyRoute = route('admin.perangkat-daerah.galeri.destroy', ['perangkatDaerah' => $perangkatDaerah, 'galeri' => $item]);
                                        }
                                    @endphp
                                <form action="{{ $destroyRoute }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus media ini?');" class="absolute top-2 right-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-white text-xl opacity-0 group-hover:opacity-100 transition-all transform hover:scale-110 hover:text-red-500 bg-black/30 rounded-full w-8 h-8 flex items-center justify-center"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @php renderEmptyState('fa-video', 'Video Upload'); @endphp
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-[#FCE405] pl-4 mb-6">Video (YouTube)</h2>
            @if ($videoYTItems->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($videoYTItems as $item)
                        @php
                            $videoId = null;
                            $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
                            if (preg_match($pattern, $item->file_url, $matches)) {
                                $videoId = $matches[1];
                            }
                            $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'https://placehold.co/1280x720/e2e8f0/64748b?text=Invalid+URL';
                        @endphp
                        <div class="relative group aspect-video bg-slate-800 rounded-lg overflow-hidden shadow-md">
                            <img src="{{ $thumbnailUrl }}" alt="Thumbnail for {{ $item->judul }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 flex items-center justify-center transition-all duration-300">
                                <i class="fab fa-youtube text-red-600 text-5xl opacity-80 group-hover:opacity-100 transition-opacity"></i>
                                @can('delete', $item)
                                    @php
                                        $destroyRoute = '#';
                                        if (isset($kecamatan)) {
                                            $destroyRoute = route('admin.kecamatan.galeri.destroy', ['kecamatan' => $kecamatan, 'galeri' => $item]);
                                        } elseif (isset($perangkatDaerah)) {
                                            $destroyRoute = route('admin.perangkat-daerah.galeri.destroy', ['perangkatDaerah' => $perangkatDaerah, 'galeri' => $item]);
                                        }
                                    @endphp
                                <form action="{{ $destroyRoute }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus media ini?');" class="absolute top-2 right-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-white text-xl opacity-0 group-hover:opacity-100 transition-all transform hover:scale-110 hover:text-red-500 bg-black/30 rounded-full w-8 h-8 flex items-center justify-center"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @php renderEmptyState('fa-youtube', 'Video YouTube'); @endphp
            @endif
        </div>

        @if ($galeris->hasPages())
            <div class="mt-12 bg-white p-4 rounded-xl shadow-lg">
                {{ $galeris->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(10px); }
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
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(form a)');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                if (link.closest('form[onsubmit]')) {
                    return;
                }
                event.preventDefault();
                document.body.classList.add('fading-out');
                setTimeout(() => {
                    window.location.href = link.href;
                }, fadeOutDuration);
            });
        });

        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                document.body.classList.remove('fading-out');
            }
        });
    });
</script>
@endsection
