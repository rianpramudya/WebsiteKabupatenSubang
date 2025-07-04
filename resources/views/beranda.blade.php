@extends('layouts.app')

@section('title', 'Beranda - Portal Resmi Kabupaten Subang')

@push('styles')
<style>
/* === DEFINISI ANIMASI === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* === KELAS HELPER ANIMASI === */
/* Kita menggunakan CSS Variable (--anim-delay) agar kode lebih bersih 
  dan menghindari error palsu pada editor.
*/
.anim-fade-in-up {
    opacity: 0;
    animation: fadeInUp 0.8s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in-down {
    opacity: 0;
    animation: fadeInDown 0.8s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in-left {
    opacity: 0;
    animation: fadeInLeft 0.8s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in {
    opacity: 0;
    animation: fadeIn 1s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
</style>
@endpush

@section('content')

{{-- ========== BAGIAN HERO / BANNER UTAMA ========== --}}
<div class="relative bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?q=80&w=2070&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-60"></div>
    <div class="relative container mx-auto px-6 pt-24 pb-48 text-center text-white">
        {{-- Animasi untuk judul --}}
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 anim-fade-in-down" style="--anim-delay: 200ms;">
            Portal Digital Kabupaten Subang
        </h1>
        {{-- Animasi untuk paragraf --}}
        <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto anim-fade-in-up" style="--anim-delay: 400ms;">
            Temukan informasi dan layanan terintegrasi dari 30 kecamatan di bawah satu atap untuk mewujudkan Subang Jawara.
        </p>
        {{-- Animasi untuk tombol --}}
        <a href="#main-content" class="mt-8 inline-block bg-green-600 text-white font-bold py-3 px-8 rounded-full text-sm uppercase transition-all duration-300 ease-in-out hover:bg-green-700 hover:shadow-lg hover:-translate-y-1 active:scale-95 anim-fade-in-up" style="--anim-delay: 600ms;">
            Jelajahi Sekarang
        </a>
    </div>
</div>

{{-- ========== BAGIAN UTAMA KONTEN ========== --}}
<div class="container mx-auto px-6" id="main-content">
    <div class="-mt-32 relative z-10">

        {{-- ========== BAGIAN BERITA TERKINI ========== --}}
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white drop-shadow mb-4 px-2 anim-fade-in-left" style="--anim-delay: 800ms;">Berita Terkini</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($beritaTerkini as $berita)
                    {{-- Animasi staggered untuk setiap kartu berita --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden group transform transition-transform duration-500 ease-in-out hover:shadow-2xl hover:-translate-y-2 anim-fade-in-up" style="--anim-delay: {{ 900 + ($loop->iteration * 150) }}ms;">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="block">
                            <div class="overflow-hidden">
                                <img 
                                    src="{{ $berita->gambar ? asset('storage/berita/' . $berita->gambar) : 'https://placehold.co/600x400/cccccc/ffffff?text=Gambar+Berita' }}" 
                                    alt="Gambar {{ $berita->judul }}" 
                                    class="w-full h-40 object-cover transform transition-transform duration-500 group-hover:scale-110"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/64748b?text=No+Image';"
                                >
                            </div>
                            <div class="p-5">
                                <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                    {{ $berita->kategori->nama ?? 'Tanpa Kategori' }}
                                </span>
                                <h3 class="mt-3 mb-2 font-bold text-lg text-gray-900 group-hover:text-green-700 transition-colors">
                                    {{ $berita->judul }}
                                </h3>
                                <p class="text-sm text-gray-600">
                                    {{ $berita->excerpt }}
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 anim-fade-in">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>

            {{-- Tombol ke semua berita --}}
            @if($beritaTerkini->isNotEmpty())
            <div class="text-center mt-8 mb-16 anim-fade-in" style="--anim-delay: {{ 1000 + ($beritaTerkini->count() * 150) }}ms;">
              <a href="{{ route('berita.index') }}" 
                 class="inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-md transition-all duration-300 ease-in-out 
                 hover:bg-blue-700 hover:shadow-lg hover:-translate-y-1 hover:scale-105">
                  Lihat Semua Berita
               </a>
            </div>
            @endif

           {{-- ========== DAFTAR KECAMATAN ========== --}}
            <div class="relative bg-cover bg-center rounded-2xl overflow-hidden shadow-xl anim-fade-in" style="background-image: url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?q=80&w=2070&auto=format&fit=crop'); --anim-delay: 1200ms;">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-60 rounded-2xl"></div>
                <div class="relative container mx-auto px-6 py-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-10 text-center anim-fade-in-down" style="--anim-delay: 1300ms;">Jelajahi Wilayah Kecamatan</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        @forelse ($kecamatans as $kecamatan)
                            {{-- Animasi staggered untuk setiap kecamatan --}}
                            <a href="{{ url('/kecamatan/' . $kecamatan->slug) }}" class="block group kecamatan-item anim-fade-in-up" title="Lihat detail Kecamatan {{ $kecamatan->name }}" style="--anim-delay: {{ 1400 + ($loop->iteration * 100) }}ms;">
                                <div class="border border-gray-200 rounded-xl p-2 flex items-center justify-center text-center aspect-square bg-white/90 transition-all duration-300 hover:shadow-xl hover:border-green-500 hover:-translate-y-1.5">
                                    <span class="text-gray-800 font-semibold text-sm md:text-base group-hover:text-green-600 transition-colors nama-kecamatan">
                                        {{ $kecamatan->name }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p class="col-span-full text-center text-gray-200 anim-fade-in">
                                Data kecamatan tidak ditemukan. Pastikan Anda sudah menjalankan <code>php artisan migrate:fresh --seed</code>.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
