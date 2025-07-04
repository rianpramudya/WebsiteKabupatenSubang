@extends('layouts.app')

@section('title', 'Visi dan Misi - ' . $nama_wilayah)

@push('styles')
<style>
    .animated-fade {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .animated-fade.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-100">

    {{-- Banner Judul Halaman --}}
    <div class="relative text-center bg-cover bg-center py-24 md:py-32"
        style="background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0.3)), url('https://images.unsplash.com/photo-1579546929518-9e396f3cc809?q=80&w=2070&auto=format&fit=crop');">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.5);">Visi & Misi</h1>
        <p class="mt-3 text-lg md:text-xl text-gray-200">{{ $nama_wilayah }}</p>
    </div>

    {{-- Konten Utama --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 -mt-16 pb-20 space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 animated-fade">
            {{-- Kolom Visi --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-2xl shadow-2xl h-full flex flex-col justify-center text-center border-t-8 border-green-500">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Visi</h2>
                    <p class="text-lg text-gray-600 italic leading-relaxed">
                        "{{ strip_tags($visi ?? 'Visi belum tersedia.') }}"
                    </p>
                </div>
            </div>

            {{-- Kolom Misi --}}
            <div class="lg:col-span-3">
                <div class="bg-white p-8 rounded-2xl shadow-lg h-full transition duration-300 hover:shadow-xl">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-gray-100 pb-4">Misi</h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! $misi ?? '<p>Misi belum tersedia.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.animated-fade');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    items.forEach((item, index) => {
        item.style.transitionDelay = `${index * 0.2}s`;
        observer.observe(item);
    });
});
</script>
@endpush
