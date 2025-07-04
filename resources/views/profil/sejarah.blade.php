@extends('layouts.app')

@section('title', 'Sejarah - ' . $nama_wilayah)

@push('styles')
<style>
    .timeline-item {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .timeline-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .timeline-line {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0;
        width: 4px;
        background-color: #e5e7eb;
    }

    .timeline-dot {
        position: absolute;
        left: 50%;
        top: 1rem;
        transform: translateX(-50%);
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 9999px;
        background-color: white;
        border: 4px solid #10b981;
        z-index: 10;
    }

    .timeline-content {
        transition: all 0.8s ease-out;
    }

    .fade-in-left {
        transform: translateX(-50px);
    }

    .fade-in-right {
        transform: translateX(50px);
    }

    .fade-in-up {
        transform: translateY(50px);
    }

    .is-visible.fade-in-left,
    .is-visible.fade-in-right,
    .is-visible.fade-in-up {
        transform: translate(0, 0);
        opacity: 1;
    }

    @media (max-width: 1023px) {
        .timeline-line {
            left: 1.25rem;
            transform: translateX(-50%);
        }
        .timeline-dot {
            left: 1.25rem;
        }
        .timeline-content {
            width: 100%;
            padding-left: 3.5rem;
        }
    }
</style>
@endpush

@section('content')

<div class="bg-gray-100">
    {{-- Banner --}}
    <div class="bg-gray-800 text-white py-16 text-center bg-cover bg-center" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1505664194779-8beaceb93744?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aGlzdG9yeXxlbnwwfHwwfHx8MA%3D%3D');">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">Sejarah</h1>
            <p class="text-gray-300 mt-2 text-xl">{{ $nama_wilayah }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Timeline --}}
            <div class="lg:col-span-2">
                <div class="relative">
                    <div class="timeline-line hidden lg:block"></div>

                    {{-- Pembuka --}}
                    <div class="timeline-item fade-in-up space-y-4 delay-0">
                        <div class="bg-white p-8 rounded-2xl shadow-lg border-t-4 border-green-500">
                            <h2 class="text-3xl font-bold text-gray-800 mb-4">Awal Mula</h2>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! $sejarah !!}
                            </div>
                        </div>
                    </div>

                    {{-- Loop dinamis --}}
                    @foreach ($sejarah_items as $index => $item)
                    @php
                        $fadeClass = $loop->odd ? 'fade-in-left' : 'fade-in-right';
                        $delay = $index + 1;
                    @endphp
                    <div class="relative mt-12 timeline-item {{ $fadeClass }} delay-{{ $delay }}">
                        <div class="timeline-dot"></div>
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            @if($loop->odd)
                                <div class="timeline-content lg:order-last">
                                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                                        <p class="text-gray-600">{{ $item->deskripsi }}</p>
                                    </div>
                                </div>
                                <div class="lg:pl-8 mb-4 lg:mb-0">
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $item->tahun }}</h3>
                                    <p class="text-gray-500">{{ $item->judul }}</p>
                                </div>
                            @else
                                <div class="lg:text-right lg:pr-8 mb-4 lg:mb-0">
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $item->tahun }}</h3>
                                    <p class="text-gray-500">{{ $item->judul }}</p>
                                </div>
                                <div class="timeline-content">
                                    <div class="bg-white p-6 rounded-2xl shadow-lg">
                                        <p class="text-gray-600">{{ $item->deskripsi }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- Arti Lambang --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-8 rounded-2xl shadow-lg sticky top-24 timeline-item fade-in-up delay-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-3">Arti Lambang</h2>
                    <div class="w-full flex justify-center my-6">
                        <img src="{{ $logo_url ?? 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Logo_Kabupaten_Subang.png' }}" alt="Lambang {{ $nama_wilayah }}" class="h-48 transition-transform duration-300 hover:scale-110">
                    </div>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                        {!! $arti_lambang !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.timeline-item');

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
        item.style.transitionDelay = `${index * 0.2}s`; // Delay animasi bertahap
        observer.observe(item);
    });
});
</script>
@endpush
