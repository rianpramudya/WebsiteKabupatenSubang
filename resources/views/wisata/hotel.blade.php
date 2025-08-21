@extends('layouts.app')

@php
    $judulHalaman = 'Infografis Kabupaten Subang'; // Default
    if (isset($currentPerangkatDaerah)) {
        $judulHalaman = 'Infografis ' . $currentPerangkatDaerah->name;
    } elseif (isset($currentKecamatan)) {
        $judulHalaman = 'Infografis Kecamatan ' . $currentKecamatan->name;
    }
@endphp

@section('title', $judulHalaman)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
    .anim-fade-in-up { opacity: 0; animation: fadeInUp 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
    .anim-fade-in-down { opacity: 0; animation: fadeInDown 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
    .anim-fade-in-left { opacity: 0; animation: fadeInLeft 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
    .anim-fade-in-right { opacity: 0; animation: fadeInRight 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
    </style>
@endpush

@section('content')
    <div class="w-full relative text-center bg-cover bg-center py-24 md:py-28"
        style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?w=900&auto=format&fit=crop&q=60');">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down" style="--anim-delay: 200ms;">
            {{ $judulHalaman }}
        </h1>
        <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
            Informasi visual mengenai data dan layanan publik.
        </p>
    </div>

    <div class="bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <form action="{{ url()->current() }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm anim-fade-in-left" style="--anim-delay: 600ms;">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Cari Infografis..." value="{{ request('search') }}"
                                class="w-full border-gray-300 rounded-md focus:ring-[#1E4E7C] focus:border-[#1E4E7C] pl-10">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </form>

                    @forelse ($infografis as $item)
                        <div class="block bg-white p-5 rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 group cursor-pointer anim-fade-in-up infografis-card"
                             data-judul="{{ $item->judul }}"
                             data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/800x1200/e2e8f0/64748b?text=Infografis' }}"
                             data-deskripsi="{{ strip_tags($item->deskripsi) }}"
                             data-tanggal="Dipublikasikan pada {{ $item->published_at->translatedFormat('d F Y') }}"
                             style="--anim-delay: {{ 700 + ($loop->iteration * 150) }}ms;">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="w-full sm:w-1/3 h-48 sm:h-auto overflow-hidden rounded-lg">
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x600/e2e8f0/64748b?text=Infografis' }}"
                                        alt="{{ $item->judul }}"
                                        class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors">{{ $item->judul }}</h2>
                                    <p class="text-xs text-gray-500 mt-1 mb-3">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $item->published_at->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit(strip_tags($item->deskripsi), 200) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-10 rounded-lg shadow-sm text-center anim-fade-in-up" style="--anim-delay: 700ms;">
                            <i class="fas fa-search-minus text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-semibold">Infografis tidak ditemukan.</p>
                        </div>
                    @endforelse

                    @if ($infografis->hasPages())
                        <div class="mt-8 anim-fade-in-up" style="--anim-delay: {{ 800 + ($infografis->count() * 150) }}ms;">
                            {{ $infografis->links() }}
                        </div>
                    @endif
                </div>
                @include('partials.sidebar_berita_terkini')
            </div>
        </div>
    </div>

    {{-- MODIFIKASI TOTAL BAGIAN MODAL --}}
    <div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden backdrop-blur-sm">
        <div id="modal-overlay" class="fixed inset-0 bg-black/60 cursor-pointer"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] flex flex-col anim-fade-in-down">
            <img id="modal-gambar" src="" alt="Gambar Infografis" class="w-full h-48 object-cover rounded-t-xl">
            <div class="p-6 overflow-y-auto">
                <h2 id="modal-judul" class="text-2xl font-bold text-gray-900"></h2>
                <p id="modal-tanggal" class="text-xs text-gray-500 mt-1 mb-4"></p>
                <p id="modal-deskripsi" class="text-base text-gray-700 leading-relaxed whitespace-pre-wrap"></p>
            </div>
            <div class="p-4 border-t border-gray-200 bg-gray-50 text-right rounded-b-xl">
                 <button id="close-modal-btn-footer" class="bg-[#1E4E7C] hover:brightness-90 text-white px-4 py-2 rounded-lg transition">Tutup</button>
            </div>
            <button id="close-modal-btn" class="absolute top-3 right-3 text-white bg-black/30 hover:bg-black/50 rounded-full w-8 h-8 flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('[DEBUG] Script Pop-up Infografis Dimulai.');

    const modal = document.getElementById('detail-modal');
    const cards = document.querySelectorAll('.infografis-card');
    
    console.log(`[DEBUG] Menemukan ${cards.length} kartu infografis.`);

    if (!modal) {
        console.error('[DEBUG] ERROR: Elemen modal dengan ID "detail-modal" tidak ditemukan!');
        return;
    }

    const modalJudul = document.getElementById('modal-judul');
    const modalGambar = document.getElementById('modal-gambar');
    const modalDeskripsi = document.getElementById('modal-deskripsi');
    const closeModalBtns = document.querySelectorAll('#close-modal-btn, #close-modal-btn-footer, #modal-overlay');

    function openModalWithData(card) {
        console.log('[DEBUG] KARTU DIKLIK! Membuka modal...');
        
        const judul = card.dataset.judul;
        const gambar = card.dataset.gambar;
        const deskripsi = card.dataset.deskripsi;
        
        modalJudul.textContent = judul;
        modalGambar.src = gambar;
        modalGambar.alt = "Gambar " + judul;
        modalDeskripsi.textContent = deskripsi;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        console.log('[DEBUG] Menutup modal.');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    if (cards.length > 0) {
        cards.forEach((card, index) => {
            console.log(`[DEBUG] Memasang listener pada kartu ke-${index + 1}`);
            card.addEventListener('click', function() {
                openModalWithData(this);
            });
        });
    } else {
        console.warn('[DEBUG] Peringatan: Tidak ada elemen dengan class ".infografis-card" yang ditemukan.');
    }

    closeModalBtns.forEach(btn => btn.addEventListener('click', closeModal));

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush