@extends('layouts.app')

@section('title', $berita->judul)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
/* === DEFINISI ANIMASI === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* === KELAS HELPER ANIMASI === */
.anim-fade-in-up {
    opacity: 0;
    animation: fadeInUp 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in-down {
    opacity: 0;
    animation: fadeInDown 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-scale-in {
    opacity: 0;
    animation: scaleIn 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
</style>
@endpush

@section('content')

<div class="bg-white py-12">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            
            {{-- Navigasi Breadcrumb --}}
            <nav class="text-sm mb-6 text-gray-500 anim-fade-in-down" style="--anim-delay: 200ms;">
                <a href="/" class="hover:underline">Home</a>
                <span class="mx-2">></span>
                <a href="{{ route('berita.index') }}" class="hover:underline">Berita</a>
            </nav>

            {{-- Judul Berita --}}
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 tracking-tight mb-3 anim-fade-in-down" style="--anim-delay: 300ms;">
                {{ $berita->judul }}
            </h1>

            {{-- Info Penulis/Tanggal --}}
            <div class="flex items-center text-sm text-gray-500 mb-8 pb-8 border-b anim-fade-in-up" style="--anim-delay: 450ms;">
                <span>Dipublikasikan pada {{ \Carbon\Carbon::parse($berita->published_at)->isoFormat('D MMMM YYYY, HH:mm') }}</span>
                <span class="mx-2">|</span>
                <span class="font-semibold text-green-600">{{ $berita->kategori->nama ?? 'Tanpa Kategori' }}</span>
            </div>

            {{-- Gambar Utama Berita --}}
            @if($berita->gambar)
            <div class="mb-8 anim-scale-in" style="--anim-delay: 600ms;">
                <img src="{{ asset('storage/berita/' . $berita->gambar) }}" 
                     alt="Gambar {{ $berita->judul }}" 
                     class="w-full rounded-lg shadow-lg"
                     onerror="this.onerror=null;this.src='https://placehold.co/1200x600/e2e8f0/64748b?text=Gambar+Utama';">
            </div>
            @endif

            {{-- Isi Konten Berita --}}
            <div class="prose max-w-none text-gray-700 leading-relaxed anim-fade-in-up" style="--anim-delay: 750ms;">
                {{-- Menggunakan {!! !!} agar bisa merender HTML dari editor --}}
                {!! $berita->isi !!}
            </div>

            {{-- Tombol Bagikan Artikel --}}
            <div class="mt-10 pt-6 border-t anim-fade-in-up" style="--anim-delay: 900ms;">
                <h4 class="font-bold text-gray-800 mb-3">Bagikan Artikel</h4>
                <div class="flex space-x-2">
                    {{-- Ganti '#' dengan link share yang sebenarnya --}}
                    <a href="#" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="bg-sky-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-sky-600 transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-600 transition"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
