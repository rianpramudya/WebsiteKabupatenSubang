@extends('layouts.app')

@php
    $namaKonteks = 'Kabupaten Subang'; // Default
    if (isset($currentPerangkatDaerah)) {
        $namaKonteks = $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan)) {
        $namaKonteks = 'Kecamatan ' . $currentKecamatan->name;
    }
@endphp

@section('title', 'Peran dan Program - ' . $namaKonteks)

@push('styles')
<style>

    .program-tabs .tab-item {
        display: flex; align-items: center; padding: 1rem; border-radius: 0.5rem;
        cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
        border: 1px solid transparent; margin-bottom: 0.5rem;
    }
    .program-tabs .tab-item:hover {
        background-color: rgba(30, 78, 124, 0.1);
        color: #1E4E7C;
    }
    .program-tabs .tab-item.active {
        background-color: #1E4E7C;
        color: white; font-weight: 600;
        box-shadow: 0 4px 14px 0 rgba(30, 78, 124, 0.39);
        transform: scale(1.02);
    }
    .program-tabs .tab-item.active .tab-icon { color: white; }

    .content-panel { display: none; animation: fadeIn 0.7s ease-in-out; }
    .content-panel.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .animated-item { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .animated-item.is-visible { opacity: 1; transform: translateY(0); }
</style>
@endpush

@section('content')
<div class="bg-gray-100 min-h-screen py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16 animated-item">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#1E4E7C] tracking-tight">
                Peran dan Program
            </h1>

            <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $namaKonteks }}
            </p>
        </div>

        @if($peran_dan_program->isEmpty())
        <div class="bg-white/70 backdrop-blur-sm rounded-lg shadow-lg p-12 text-center animated-item">
            <p class="text-gray-600 text-lg">Informasi mengenai peran dan program untuk wilayah ini belum tersedia.</p>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8 animated-item">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/3 lg:w-1/4">
                    <div class="program-tabs space-y-2">
                        @foreach ($peran_dan_program as $index => $item)
                        <div class="tab-item" data-target="content-{{ $item->id }}">
                            <span class="tab-icon mr-3 text-[#1E4E7C]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </span>
                            <span class="text-md">{{ $item->judul }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full md:w-2/3 lg:w-3/4">
                    @foreach ($peran_dan_program as $index => $item)
                    <div id="content-{{ $item->id }}" class="content-panel">
                        <div class="bg-gray-50 rounded-lg p-8 min-h-[200px]">
                            <h3 class="text-3xl font-bold text-[#1E4E7C] mb-4">{{ $item->judul }}</h3>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! $item->deskripsi !!}
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

        const tabs = document.querySelectorAll('.tab-item');
        const contentPanels = document.querySelectorAll('.content-panel');

        function activateTab(tab) {
            const targetId = tab.dataset.target;

            tabs.forEach(t => t.classList.remove('active'));
            contentPanels.forEach(p => p.classList.remove('active'));

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

        if (tabs.length > 0) {
            activateTab(tabs[0]);
        }
    });
</script>
@endpush