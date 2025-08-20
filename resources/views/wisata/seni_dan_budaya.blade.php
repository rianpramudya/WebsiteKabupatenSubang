@extends('layouts.app')

@section('title', 'Seni dan Budaya - ' . (isset($currentKecamatan) ? $currentKecamatan->name : 'Kabupaten Subang'))

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
    style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1606819717115-9159c900370b?q=80&w=2370&auto=format&fit=crop');">
    {{-- WARNA DIUBAH --}}
    <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down" style="--anim-delay: 200ms;">Seni dan Budaya</h1>
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
                        <input type="text" name="search" placeholder="Cari Seni Budaya..." value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md focus:ring-[#1E4E7C] focus:border-[#1E4E7C] pl-10">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>

                @forelse ($budayas as $item)
                <div class="block bg-white p-5 rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 group anim-fade-in-up cursor-pointer budaya-card"
                     data-nama="{{ $item->nama }}"
                     data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300/e2e8f0/64748b?text=Gambar' }}"
                     data-tanggal="Dipublikasikan pada {{ $item->published_at->translatedFormat('d F Y') }}"
                     data-deskripsi="{{ strip_tags($item->deskripsi) }}"
                     @style(['--anim-delay' => (700 + ($loop->iteration * 150)) . 'ms'])>
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-full sm:w-1/3 h-48 sm:h-auto overflow-hidden rounded-lg">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300/e2e8f0/64748b?text=Gambar' }}" alt="{{ $item->nama }}" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="flex-1">
                            {{-- WARNA DIUBAH --}}
                            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors">{{ $item->nama }}</h2>
                            <p class="text-xs text-gray-500 mt-1 mb-3"><i class="far fa-calendar-alt mr-1"></i> Dipublikasikan pada {{ $item->published_at->translatedFormat('d F Y') }}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit(strip_tags($item->deskripsi), 200) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-10 rounded-lg shadow-sm text-center anim-fade-in-up" style="--anim-delay: 700ms;">
                    <i class="fas fa-search-minus text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-semibold">Seni budaya yang Anda cari tidak ditemukan.</p>
                </div>
                @endforelse

                @if ($budayas->hasPages())
                <div class="mt-8 anim-fade-in-up" @style(['--anim-delay' => (800 + ($budayas->count() * 150)) . 'ms'])>{{ $budayas->links() }}</div>
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
            <div class="mt-2 text-center">
                <img id="modal-gambar" src="" alt="Gambar Detail" class="w-full h-64 object-cover rounded-lg mb-4">
                <h2 id="modal-nama" class="text-3xl font-bold text-gray-900"></h2>
                <p id="modal-tanggal" class="text-sm text-gray-500 mt-2 mb-4"></p>
                <div id="modal-deskripsi" class="text-base text-gray-700 text-left leading-relaxed whitespace-pre-wrap"></div>
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
    const cards = document.querySelectorAll('.budaya-card');

    const modalNama = document.getElementById('modal-nama');
    const modalGambar = document.getElementById('modal-gambar');
    const modalTanggal = document.getElementById('modal-tanggal');
    const modalDeskripsi = document.getElementById('modal-deskripsi');

    cards.forEach(card => {
        card.addEventListener('click', function () {
            // 1. Ambil data dari atribut data-* kartu yang diklik
            const nama = this.dataset.nama;
            const gambar = this.dataset.gambar;
            const tanggal = this.dataset.tanggal;
            const deskripsi = this.dataset.deskripsi;

            // 2. Masukkan data ke dalam elemen-elemen di modal
            modalNama.textContent = nama;
            modalGambar.src = gambar;
            modalGambar.alt = "Gambar " + nama;
            modalTanggal.textContent = tanggal;
            modalDeskripsi.textContent = deskripsi;

            // 3. Tampilkan modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Mencegah scrolling di belakang modal
        });
    });

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Mengembalikan scrolling
    }

    // Event listener untuk tombol close
    closeModalBtn.addEventListener('click', closeModal);

    // Event listener untuk menutup modal saat mengklik area gelap di luar
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Event listener untuk menutup modal dengan tombol 'Escape'
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush