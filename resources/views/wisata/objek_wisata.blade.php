@extends('layouts.app')

@section('title', 'Objek Wisata - ' . (isset($currentKecamatan) ? $currentKecamatan->name : 'Kabupaten Subang'))

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    .anim-fade-in-up { opacity: 0; animation: fadeInUp 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
    .anim-fade-in-down { opacity: 0; animation: fadeInDown 0.7s ease-out forwards; animation-delay: var(--anim-delay, 0ms); }
</style>
@endpush

@section('content')
<div class="bg-gray-50">
    <div class="relative text-center bg-cover bg-center py-24 md:py-28"
        style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=2070&auto=format&fit=crop');">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down"
            style="--anim-delay: 200ms;">Objek Wisata</h1>
        <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
            {{ isset($currentKecamatan) ? 'Kecamatan ' . $currentKecamatan->name : 'Kabupaten Subang' }}
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="relative z-20 bg-white p-6 rounded-2xl shadow-lg mb-10 anim-fade-in-up"
                    style="--anim-delay: 600ms;">
                    <form action="{{ url()->current() }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <div class="md:col-span-1">
                            <div class="relative">
                                <input type="text" name="search" placeholder="Cari nama objek wisata..."
                                    value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#1E4E7C] focus:border-[#1E4E7C] shadow-sm placeholder-gray-400">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ open: false, selected: '{{ request('kategori') ? $kategori_filter->firstWhere(fn($k) => $k == request('kategori')) : 'Semua Kategori' }}' }"
                            class="relative md:col-span-1">
                            <button type="button" @click="open = !open"
                                class="w-full flex justify-between items-center bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1E4E7C] transition">
                                <span x-text="selected || 'Semua Kategori'"></span>
                                <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                class="absolute mt-2 w-full bg-white rounded-xl shadow-lg z-10 overflow-hidden border border-gray-200">
                                <a href="?search={{ request('search') }}"
                                    @click="selected = 'Semua Kategori'; open = false"
                                    class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 {{ request('kategori') == '' ? 'bg-gray-100 font-semibold' : '' }}">Semua
                                    Kategori</a>
                                @foreach ($kategori_filter as $kategori)
                                <a href="?search={{ request('search') }}&kategori={{ $kategori }}"
                                    @click="selected = '{{ $kategori }}'; open = false"
                                    class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700 {{ request('kategori') == $kategori ? 'bg-gray-100 font-semibold' : '' }}">{{
                                    $kategori }}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="md:col-span-1 flex justify-start md:justify-end">
                            <button type="submit"
                                class="bg-[#1E4E7C] hover:brightness-90 text-white font-semibold px-6 py-2 rounded-full transition duration-200 shadow-md">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($objek_wisatas as $wisata)
                    {{-- PERUBAHAN 1: Menambahkan class 'wisata-card' dan data-* attributes --}}
                    <div class="bg-white rounded-2xl shadow hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden group anim-fade-in-up cursor-pointer wisata-card"
                        @style(['--anim-delay'=> (700 + ($loop->iteration * 150)) . 'ms'])
                        data-nama="{{ $wisata->nama }}"
                        data-gambar="{{ $wisata->gambar ? asset('storage/' . $wisata->gambar) : 'https://placehold.co/600x400/e2e8f0/64748b?text=Wisata' }}"
                        data-kategori="{{ $wisata->kategori }}"
                        data-lokasi="{{ $wisata->lokasi_teks }}"
                        data-deskripsi="{{ $wisata->deskripsi }}"
                        data-googlemaps="{{ $wisata->url_google_maps }}">
                        <div class="relative">
                            <img src="{{ $wisata->gambar ? asset('storage/' . $wisata->gambar) : 'https://placehold.co/600x400/e2e8f0/64748b?text=Wisata' }}"
                                alt="{{ $wisata->nama }}"
                                class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($wisata->is_unggulan)
                            <span
                                class="absolute top-2 right-2 bg-[#FCE405] text-[#1E4E7C] text-xs font-bold px-3 py-1 rounded-lg shadow-sm">Unggulan</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-sm font-medium text-[#1E4E7C]">{{ $wisata->kategori }}</p>
                            <h3
                                class="mt-1 text-lg font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors truncate">
                                {{ $wisata->nama }}</h3>
                            <p class="text-sm text-gray-500 mt-1 flex items-center"><i
                                    class="fas fa-map-marker-alt mr-2 text-gray-400"></i>{{ $wisata->lokasi_teks }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-xl shadow-sm anim-fade-in-up"
                        style="--anim-delay: 700ms;">
                        <i class="fas fa-map-signs text-5xl text-gray-300 mb-4"></i>
                        <p class="text-xl font-semibold text-gray-500">Objek Wisata Tidak Ditemukan</p>
                    </div>
                    @endforelse
                </div>

                @if ($objek_wisatas->hasPages())
                <div class="mt-12 anim-fade-in-up" @style(['--anim-delay'=> (800 + ($objek_wisatas->count() * 150)) .
                    'ms'])>{{ $objek_wisatas->links() }}</div>
                @endif
            </div>

            @include('partials.sidebar_berita_terkini')

        </div>
    </div>
</div>

{{-- PERUBAHAN 2: Menambahkan struktur HTML untuk Modal (Pop-up) --}}
<div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden backdrop-blur-sm">
    <div id="modal-overlay" class="fixed inset-0 bg-black/60 cursor-pointer"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col anim-fade-in-down">
        <img id="modal-gambar" src="" alt="Gambar Wisata" class="w-full h-64 object-cover rounded-t-xl bg-gray-200">
        <div class="p-6 overflow-y-auto">
            <p id="modal-kategori" class="text-sm font-bold text-[#1E4E7C] mb-1"></p>
            <h2 id="modal-nama" class="text-3xl font-bold text-gray-900"></h2>
            <p id="modal-lokasi" class="text-base text-gray-500 mt-2 flex items-center"><i class="fas fa-map-marker-alt mr-2 text-gray-400"></i><span id="modal-lokasi-teks"></span></p>
            
            <div id="modal-deskripsi" class="prose max-w-none mt-4 text-gray-600"></div>
        </div>
        <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center rounded-b-xl">
             <a id="modal-googlemaps" href="#" target="_blank" class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200 transition" style="display: none;"><i class="fas fa-map-marked-alt mr-2"></i>Lihat di Peta</a>
             <button id="close-modal-btn-footer" class="bg-[#1E4E7C] hover:brightness-90 text-white px-4 py-2 rounded-lg transition">Tutup</button>
        </div>
        <button id="close-modal-btn" class="absolute top-3 right-3 text-white bg-black/30 hover:bg-black/50 rounded-full w-8 h-8 flex items-center justify-center transition">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
{{-- PERUBAHAN 3: Menambahkan JavaScript untuk mengontrol Modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('detail-modal');
    if (!modal) return;

    const cards = document.querySelectorAll('.wisata-card');
    
    // Elemen di dalam Modal
    const modalNama = document.getElementById('modal-nama');
    const modalGambar = document.getElementById('modal-gambar');
    const modalKategori = document.getElementById('modal-kategori');
    const modalLokasiTeks = document.getElementById('modal-lokasi-teks');
    const modalDeskripsi = document.getElementById('modal-deskripsi');
    const modalGoogleMaps = document.getElementById('modal-googlemaps');
    const closeModalBtns = document.querySelectorAll('#close-modal-btn, #close-modal-btn-footer, #modal-overlay');

    function openModalWithData(card) {
        const nama = card.dataset.nama || 'Nama tidak tersedia';
        const gambar = card.dataset.gambar || '';
        const kategori = card.dataset.kategori || 'Kategori tidak tersedia';
        const lokasi = card.dataset.lokasi || 'Lokasi tidak tersedia';
        const deskripsi = card.dataset.deskripsi || '<p>Deskripsi tidak tersedia.</p>';
        const googlemaps = card.dataset.googlemaps;
        
        modalNama.textContent = nama;
        modalGambar.src = gambar;
        modalGambar.alt = "Gambar " + nama;
        modalKategori.textContent = kategori;
        modalLokasiTeks.textContent = lokasi;
        modalDeskripsi.innerHTML = deskripsi;
        
        if (googlemaps && googlemaps.trim() !== '') {
            modalGoogleMaps.href = googlemaps;
            modalGoogleMaps.style.display = 'inline-flex';
        } else {
            modalGoogleMaps.style.display = 'none';
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    cards.forEach(card => {
        card.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah link default berjalan
            openModalWithData(this);
        });
    });

    closeModalBtns.forEach(btn => btn.addEventListener('click', closeModal));

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush