@extends('layouts.app')

@section('title', 'Hotel - ' . (isset($currentKecamatan) ? $currentKecamatan->name : 'Kabupaten Subang'))

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
    style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop');">
    {{-- WARNA DIUBAH --}}
    <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down" style="--anim-delay: 200ms;">Akomodasi Hotel</h1>
    <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
        {{ isset($currentKecamatan) ? 'Kecamatan ' . $currentKecamatan->name : 'Kabupaten Subang' }}
    </p>
</div>

<div class="bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <form action="{{ url()->current() }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm anim-fade-in-left" style="--anim-delay: 600ms;">
                    <div class="relative">
                        {{-- WARNA DIUBAH --}}
                        <input type="text" name="search" placeholder="Cari nama hotel..." value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md focus:ring-[#1E4E7C] focus:border-[#1E4E7C] pl-10">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>

                @forelse ($hotels as $item)
                <div class="block bg-white p-5 rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 group anim-fade-in-up cursor-pointer hotel-card" 
                     @style(['--anim-delay' => (700 + ($loop->iteration * 150)) . 'ms'])
                     data-nama="{{ $item->nama }}"
                     data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300/e2e8f0/64748b?text=Gambar+Hotel' }}"
                     data-bintang="{{ $item->bintang }}"
                     data-alamat="{{ strip_tags($item->alamat) }}"
                     data-deskripsi="{{ strip_tags($item->deskripsi) }}"
                     data-telepon="{{ $item->telepon }}"
                     data-website="{{ $item->website_url }}">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-full sm:w-1/3 h-48 sm:h-auto overflow-hidden rounded-lg">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300/e2e8f0/64748b?text=Gambar+Hotel' }}"
                                alt="{{ $item->nama }}"
                                class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                {{-- WARNA DIUBAH --}}
                                <h2 class="text-2xl font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors">{{ $item->nama }}</h2>
                                @if($item->bintang)
                                {{-- WARNA DIUBAH --}}
                                <div class="flex items-center bg-[#FCE405] text-[#1E4E7C] text-xs font-bold px-2 py-1 rounded-md">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>{{ $item->bintang }}</span>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-1 mb-3"><i class="fas fa-map-marker-alt mr-1"></i> {{ strip_tags($item->alamat) }}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit(strip_tags($item->deskripsi), 200) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-10 rounded-lg shadow-sm text-center anim-fade-in-up" style="--anim-delay: 700ms;">
                    <i class="fas fa-search-minus text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-semibold">Hotel tidak ditemukan.</p>
                </div>
                @endforelse

                @if ($hotels->hasPages())
                <div class="mt-8 anim-fade-in-up" @style(['--anim-delay' => (800 + ($hotels->count() * 150)) . 'ms'])>{{ $hotels->links() }}</div>
                @endif
            </div>

            @include('partials.sidebar_berita_terkini')
            
        </div>
    </div>
</div>

<div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-full overflow-y-auto anim-fade-in-down">
        <div class="p-5 sm:p-7">
            <div class="flex justify-end">
                <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="mt-2">
                <img id="modal-gambar" src="" alt="Gambar Detail" class="w-full h-64 object-cover rounded-lg mb-4">
                <div class="flex justify-between items-center">
                    <h2 id="modal-nama" class="text-3xl font-bold text-gray-900"></h2>
                    <div id="modal-bintang-container" class="flex items-center bg-[#FCE405] text-[#1E4E7C] text-sm font-bold px-3 py-1 rounded-md hidden">
                        <i class="fas fa-star mr-2"></i>
                        <span id="modal-bintang"></span>
                    </div>
                </div>
                <p id="modal-alamat" class="text-base text-gray-500 mt-2 mb-4 flex items-start"><i class="fas fa-map-marker-alt mr-2 text-gray-400 mt-1"></i><span></span></p>
                <div id="modal-deskripsi" class="text-base text-gray-700 text-left leading-relaxed whitespace-pre-wrap mb-6"></div>
                <div class="flex flex-wrap gap-4">
                    <a id="modal-telepon" href="#" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-full transition duration-200 shadow-md">
                        <i class="fas fa-phone-alt mr-2"></i>Hubungi
                    </a>
                    <a id="modal-website" href="#" target="_blank" class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-semibold px-6 py-2 rounded-full transition duration-200 shadow-md">
                        <i class="fas fa-globe mr-2"></i>Kunjungi Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('detail-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cards = document.querySelectorAll('.hotel-card');

    const modalNama = document.getElementById('modal-nama');
    const modalGambar = document.getElementById('modal-gambar');
    const modalBintangContainer = document.getElementById('modal-bintang-container');
    const modalBintang = document.getElementById('modal-bintang');
    const modalAlamat = document.querySelector('#modal-alamat span');
    const modalDeskripsi = document.getElementById('modal-deskripsi');
    const modalTelepon = document.getElementById('modal-telepon');
    const modalWebsite = document.getElementById('modal-website');

    cards.forEach(card => {
        card.addEventListener('click', function () {
            // Ambil data dari atribut data-* kartu yang diklik
            const nama = this.dataset.nama;
            const gambar = this.dataset.gambar;
            const bintang = this.dataset.bintang;
            const alamat = this.dataset.alamat;
            const deskripsi = this.dataset.deskripsi;
            const telepon = this.dataset.telepon;
            const website = this.dataset.website;
            
            // Masukkan data ke dalam elemen-elemen di modal
            modalNama.textContent = nama;
            modalGambar.src = gambar;
            modalGambar.alt = "Gambar " + nama;
            modalAlamat.textContent = alamat;
            modalDeskripsi.textContent = deskripsi;

            // Atur Bintang
            if (bintang && bintang.trim() !== '') {
                modalBintang.textContent = bintang;
                modalBintangContainer.classList.remove('hidden');
            } else {
                modalBintangContainer.classList.add('hidden');
            }

            // Atur link Telepon
            if (telepon && telepon.trim() !== '') {
                modalTelepon.href = 'tel:' + telepon;
                modalTelepon.classList.remove('hidden');
            } else {
                modalTelepon.classList.add('hidden');
            }

            // Atur link Website
            if (website && website.trim() !== '') {
                modalWebsite.href = website;
                modalWebsite.classList.remove('hidden');
            } else {
                modalWebsite.classList.add('hidden');
            }
            
            // Tampilkan modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    closeModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush