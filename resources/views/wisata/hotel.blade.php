@extends('layouts.app')

@section('title', 'Hotel - ' . (isset($currentKecamatan) ? $currentKecamatan->name : 'Kabupaten Subang'))

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

<div class="w-full relative text-center bg-cover bg-center py-24 md:py-28"
    style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto-format&fit=crop');">
    <h1 class="text-4xl md:text-5xl font-extrabold text-[#FCE405] drop-shadow-lg anim-fade-in-down" style="--anim-delay: 200ms;">Akomodasi Hotel</h1>
    <p class="mt-3 text-lg md:text-xl text-gray-200 anim-fade-in-up" style="--anim-delay: 400ms;">
        {{ isset($currentKecamatan) ? 'Kecamatan ' . $currentKecamatan->name : 'Kabupaten Subang' }}
    </p>
</div>

<div class="bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <form action="{{ url()->current() }}" method="GET" class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari nama hotel..." value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md focus:ring-[#1E4E7C] focus:border-[#1E4E7C] pl-10">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>

                @forelse ($hotels as $item)
                {{-- PERBAIKAN 1: Menghapus e() agar HTML bisa dibaca JavaScript --}}
                <div class="block bg-white p-5 rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 group cursor-pointer anim-fade-in-up hotel-card"
                    @style(['--anim-delay' => (700 + ($loop->iteration * 150)) . 'ms'])
                    data-nama="{{ $item->nama }}"
                    data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/800x600/e2e8f0/64748b?text=Gambar+Hotel' }}"
                    data-bintang="{{ $item->bintang }}"
                    data-alamat="{{ $item->alamat }}"
                    data-deskripsi="{{ $item->deskripsi }}"
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
                                <h2 class="text-2xl font-bold text-gray-800 group-hover:text-[#FF3B00] transition-colors">{{ $item->nama }}</h2>
                                @if($item->bintang)
                                <div class="flex items-center bg-[#FCE405] text-[#1E4E7C] text-xs font-bold px-2 py-1 rounded-md">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>{{ $item->bintang }}</span>
                                </div>
                                @endif
                            </div>
                            {{-- Menggunakan {!! !!} agar tag HTML tidak ikut ditampilkan di preview singkat --}}
                            <p class="text-sm text-gray-500 mt-1 mb-3"><i class="fas fa-map-marker-alt mr-1"></i> {!! Str::limit(strip_tags($item->alamat), 50) !!}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{!! Str::limit(strip_tags($item->deskripsi), 150) !!}</p>
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

            <aside class="lg:col-span-1 space-y-6">
                <div class="bg-white p-5 rounded-lg shadow-sm sticky top-24">
                    <h3 class="font-bold text-lg border-b pb-3 mb-4 text-[#1E4E7C]">Berita Terkini</h3>
                    <ul class="space-y-4">
                        @forelse ($berita_terkini as $berita)
                        <li>
                            <a href="#" class="flex items-center gap-4 group">
                                <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/150x150/e2e8f0/64748b?text=Berita' }}" alt="{{ $berita->judul }}" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800 group-hover:text-[#FF3B00] leading-tight transition-colors">{{ $berita->judul }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $berita->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="text-sm text-gray-400 text-center py-4">Belum ada berita terkini.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>
            
        </div>
    </div>
</div>

<div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden backdrop-blur-sm">
    <div id="modal-overlay" class="fixed inset-0 bg-black/60 cursor-pointer"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col anim-fade-in-down">
        <img id="modal-gambar" src="" alt="Gambar Hotel" class="w-full h-64 object-cover rounded-t-xl bg-gray-200">
        <div class="p-6 overflow-y-auto">
            <div class="flex justify-between items-start mb-2">
                <h2 id="modal-nama" class="text-3xl font-bold text-gray-900"></h2>
                <div id="modal-bintang-container" class="flex items-center bg-[#FCE405] text-[#1E4E7C] text-sm font-bold px-3 py-1 rounded-md" style="display: none;">
                    <i class="fas fa-star mr-2"></i>
                    <span id="modal-bintang-text"></span>
                </div>
            </div>
            
            <div class="text-gray-600 space-y-4">
                <div id="modal-alamat" class="prose max-w-none"></div>
                <div id="modal-deskripsi" class="prose max-w-none mt-4"></div>
            </div>
        </div>
        <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center rounded-b-xl">
             <div class="flex gap-2">
                 <a id="modal-telepon" href="#" class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200 transition" style="display: none;"><i class="fas fa-phone mr-2"></i>Hubungi</a>
                 <a id="modal-website" href="#" target="_blank" class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-200 transition" style="display: none;"><i class="fas fa-globe mr-2"></i>Kunjungi Website</a>
             </div>
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
    const modal = document.getElementById('detail-modal');
    if (!modal) return;

    const cards = document.querySelectorAll('.hotel-card');
    
    // Elemen di dalam Modal
    const modalNama = document.getElementById('modal-nama');
    const modalGambar = document.getElementById('modal-gambar');
    const modalBintangContainer = document.getElementById('modal-bintang-container');
    const modalBintangText = document.getElementById('modal-bintang-text');
    const modalAlamat = document.getElementById('modal-alamat');
    const modalDeskripsi = document.getElementById('modal-deskripsi');
    const modalTelepon = document.getElementById('modal-telepon');
    const modalWebsite = document.getElementById('modal-website');
    const closeModalBtns = document.querySelectorAll('#close-modal-btn, #close-modal-btn-footer, #modal-overlay');

    function openModalWithData(card) {
        const nama = card.dataset.nama || 'Nama tidak tersedia';
        const gambar = card.dataset.gambar || '';
        const bintang = card.dataset.bintang;
        const alamat = card.dataset.alamat || '<p>Alamat tidak tersedia.</p>';
        const deskripsi = card.dataset.deskripsi || '<p>Deskripsi tidak tersedia.</p>';
        const telepon = card.dataset.telepon;
        const website = card.dataset.website;
        
        modalNama.textContent = nama;
        modalGambar.src = gambar;
        modalGambar.alt = "Gambar " + nama;
        
        // PERBAIKAN 2: Menggunakan innerHTML agar tag <div>, <p>, dll. dirender
        modalAlamat.innerHTML = `<div class="flex items-start"><i class="fas fa-map-marker-alt mr-3 text-gray-400 mt-1"></i><div>${alamat}</div></div>`;
        modalDeskripsi.innerHTML = deskripsi;
        
        if (bintang && bintang !== 'null' && bintang !== '0' && bintang !== '') {
            modalBintangText.textContent = bintang;
            modalBintangContainer.style.display = 'flex';
        } else {
            modalBintangContainer.style.display = 'none';
        }

        if (telepon && telepon.trim() !== '') {
            modalTelepon.href = `tel:${telepon}`;
            modalTelepon.style.display = 'inline-flex';
        } else {
            modalTelepon.style.display = 'none';
        }
        
        // PERBAIKAN 3: Logika untuk menampilkan tombol website
        if (website && website.trim() !== '') {
            modalWebsite.href = website;
            modalWebsite.style.display = 'inline-flex';
        } else {
            modalWebsite.style.display = 'none';
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
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