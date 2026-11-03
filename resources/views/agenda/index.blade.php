@extends('layouts.app')

@php
    $judulHalaman = 'Semua Agenda';
    $subJudul = 'Jadwal acara dan kegiatan terbaru.'; // Default subtitle

    if (isset($currentPerangkatDaerah)) {
        $judulHalaman = 'Agenda ' . $currentPerangkatDaerah->name;
        $subJudul = 'Jadwal acara dan kegiatan di ' . $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan)) {
        $judulHalaman = 'Agenda Kecamatan ' . $currentKecamatan->name;
        $subJudul = 'Jadwal acara dan kegiatan di wilayah Kecamatan ' . $currentKecamatan->name;
    } else {
        $judulHalaman = 'Agenda Kabupaten Subang';
        $subJudul = 'Jadwal acara dan kegiatan di tingkat Kabupaten Subang.';
    }
@endphp

@section('title', $judulHalaman)

@section('content')
<div id="page-content" class="bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 py-12">

        <div class="text-center mb-12">

            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1E4E7C] tracking-tight">{{ $judulHalaman }}</h1>
            <p class="mt-2 text-lg text-gray-600">{{ $subJudul }}</p>
        </div>

        @if($agendasHariIni->isEmpty() && $agendasMendatang->isEmpty() && $agendasLewat->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500">
                <i class="fas fa-calendar-times text-4xl mb-4"></i>
                <p class="font-semibold">Belum Ada Agenda</p>
                <p>Saat ini belum ada agenda yang dijadwalkan.</p>
            </div>
        @else

            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-[#1E4E7C]">Agenda Hari Ini</h2>
                @forelse ($agendasHariIni as $agenda)
                    @include('agenda._agenda_card', ['agenda' => $agenda])
                @empty
                    <p class="text-gray-500 italic">Tidak ada agenda yang dijadwalkan untuk hari ini.</p>
                @endforelse
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Agenda Mendatang</h2>
                @forelse ($agendasMendatang as $agenda)
                     @include('agenda._agenda_card', ['agenda' => $agenda])
                @empty
                    <p class="text-gray-500 italic">Tidak ada agenda mendatang.</p>
                @endforelse
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-gray-200">Agenda Telah Lewat</h2>
                @forelse ($agendasLewat as $agenda)
                    @include('agenda._agenda_card', ['agenda' => $agenda])
                @empty
                    <p class="text-gray-500 italic">Tidak ada riwayat agenda.</p>
                @endforelse
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
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
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fadeOutDuration = 500;
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not(form a)');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
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
@endpush
