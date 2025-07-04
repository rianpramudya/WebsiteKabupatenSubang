@extends('layouts.app')

@section('title', 'Peran dan Program - ' . $nama_wilayah)

@push('styles')
<style>
    /* Background gradien animasi */
    .dynamic-bg {
        background: linear-gradient(-45deg, #f0f9ff, #eefbf3, #f0f9ff, #fafafa);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Tab Styling */
    .program-tabs .tab-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 0.5rem;
        /* 8px */
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
        border: 1px solid transparent;
        margin-bottom: 0.5rem;
    }

    .program-tabs .tab-item:hover {
        background-color: #e6f4ea;
        color: #166534;
        /* green-800 */
    }

    .program-tabs .tab-item.active {
        background-color: #10B981;
        /* emerald-500 */
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 14px 0 rgb(16 185 129 / 39%);
        transform: scale(1.02);
    }

    .program-tabs .tab-item.active .tab-icon {
        color: white;
    }

    /* Content Panel Styling */
    .content-panel {
        display: none;
        /* Sembunyikan semua panel secara default */
        animation: fadeIn 0.7s ease-in-out;
    }

    .content-panel.active {
        display: block;
        /* Tampilkan panel yang aktif */
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

    /* Animasi saat item muncul */
    .animated-item {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .animated-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<div class="dynamic-bg min-h-screen py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Judul Halaman --}}
        <div class="text-center mb-16 animated-item">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                Peran dan Program</span>
            </h1>
            <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">{{ $nama_wilayah }}</p>
        </div>

        @if($peran_dan_program->isEmpty())
        <div class="bg-white/70 backdrop-blur-sm rounded-lg shadow-lg p-12 text-center animated-item">
            <p class="text-gray-600 text-lg">Informasi mengenai peran dan program untuk wilayah ini belum tersedia.</p>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8 animated-item">
            <div class="flex flex-col md:flex-row gap-8">

                <!-- Kolom Navigasi Tab (Kiri) -->
                <div class="w-full md:w-1/3 lg:w-1/4">
                    <div class="program-tabs space-y-2">
                        @foreach ($peran_dan_program as $index => $item)
                        <div class="tab-item" data-target="content-{{ $item->id }}">
                            <span class="tab-icon mr-3 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </span>
                            <span class="text-md">{{ $item->judul }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kolom Konten (Kanan) -->
                <div class="w-full md:w-2/3 lg:w-3/4">
                    @foreach ($peran_dan_program as $index => $item)
                    <div id="content-{{ $item->id }}" class="content-panel">
                        <div class="bg-gray-50 rounded-lg p-8 min-h-[200px]">
                            <h3 class="text-3xl font-bold text-gray-800 mb-4">{{ $item->judul }}</h3>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <p>{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Animasi scroll
        const observer = new IntersectionObserver(
            entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            }
        );
        document.querySelectorAll('.animated-item').forEach(el => observer.observe(el));

        // Logika Tab
        const tabs = document.querySelectorAll('.tab-item');
        const contentPanels = document.querySelectorAll('.content-panel');

        function activateTab(tab) {
            const targetId = tab.dataset.target;

            // Deactivate all tabs and panels
            tabs.forEach(t => t.classList.remove('active'));
            contentPanels.forEach(p => p.classList.remove('active'));

            // Activate the clicked tab and corresponding panel
            tab.classList.add('active');
            const activePanel = document.getElementById(targetId);
            if (activePanel) {
                activePanel.classList.add('active');
            }
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                activateTab(tab);
            });
        });

        // Activate the first tab by default
        if (tabs.length > 0) {
            activateTab(tabs[0]);
        }
    });
</script>
@endpush