@extends('layouts.app')

@section('title', 'Peran dan Program - ' . $nama_wilayah)

@push('styles')
<style>
    .fade-slide-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }
    .fade-slide-left {
        opacity: 0;
        transform: translateX(-30px);
        transition: all 0.8s ease-out;
    }
    .fade-slide-right {
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.8s ease-out;
    }
    .animate-in-view {
        opacity: 1 !important;
        transform: translate(0, 0) !important;
    }
</style>
@endpush

@section('content')
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Judul Halaman --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-10 text-center border-l-8 border-green-600 fade-slide-up">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">Peran dan Program</h1>
            <p class="mt-2 text-lg md:text-xl text-gray-500">{{ $nama_wilayah }}</p>
        </div>

        {{-- Daftar Peran dan Program --}}
        <div class="space-y-6">
            @forelse ($peran_dan_program as $index => $item)
                <div class="
                    bg-white rounded-2xl shadow-md overflow-hidden 
                    transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 
                    {{ $index % 2 === 0 ? 'fade-slide-left' : 'fade-slide-right' }} 
                "style="transition-delay: {{ $index * 150 }}ms">
                    <div class="p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-green-700">{{ $item->judul }}</h2>
                        <p class="mt-4 text-gray-600 leading-relaxed">
                            {{ $item->deskripsi }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-md p-10 text-center fade-slide-up">
                    <p class="text-gray-500 text-lg">Informasi mengenai peran dan program untuk wilayah ini belum tersedia.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver(
            entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in-view');
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.15
            }
        );

        document.querySelectorAll('.fade-slide-up, .fade-slide-left, .fade-slide-right')
            .forEach(el => observer.observe(el));
    });
</script>
@endpush
