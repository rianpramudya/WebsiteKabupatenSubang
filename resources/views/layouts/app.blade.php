<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Variabel dari View Composer sekarang bisa digunakan di sini --}}
    <title>@yield('title', $isPerangkatDaerahContext ? $activePerangkatDaerah->name : ($isKecamatanContext ? 'Kecamatan
        ' . $activeKecamatan->name : 'Portal Resmi Kabupaten Subang'))</title>

    {{-- Memuat Vite dan Alpine.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f5f7;
        }

        /* Animasi untuk search bar */
        #search-input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 0;
            opacity: 0;
            padding: 0;
            border: none;
        }

        #search-input.active {
            width: 200px;
            opacity: 1;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            /* PENAMBAHAN BARU: Agar input tidak transparan */
        }

        /* PENAMBAHAN BARU: Memberi z-index agar search bar muncul di atas elemen lain */
        #search-container {
            z-index: 20;
        }

        @media (min-width: 768px) {
            #search-input.active {
                width: 250px;
            }
        }

        /* Animasi untuk menu mobile */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        .mobile-menu-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Gaya untuk hasil pencarian */
        .search-results {
            max-height: 400px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .search-result-item {
            transition: all 0.2s ease;
        }

        .search-result-item:hover {
            background-color: #f3f4f6;
            transform: translateX(2px);
        }

        /* Animasi untuk ikon hamburger */
        .hamburger-line {
            transition: all 0.3s ease;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Gaya untuk banner persetujuan cookie */
        .cookie-banner {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Fix untuk dropdown menu */
        .dropdown-menu {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Z-index hierarchy */
        .cookie-banner {
            z-index: 9999;
        }

        header {
            z-index: 1000;
        }

        .dropdown-menu {
            z-index: 1001;
        }

        .mobile-menu-overlay {
            z-index: 1998;
        }

        .mobile-menu {
            z-index: 1999;
        }

        #search-results {
            z-index: 1002;
        }

        /* Perbaikan untuk layout header */
        .header-container {
            max-width: 1280px;
        }

        /* Perbaikan untuk footer */
        .footer-grid {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        /* Animasi untuk tombol */
        .btn-animate {
            transition: all 0.2s ease;
        }

        .btn-animate:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Efek hover untuk link navigasi */
        .nav-link {
            position: relative;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #FF3B00;
            transition: width 0.3s ease;
        }

        .nav-link:hover:after {
            width: 100%;
        }

        /* Responsive header improvements */
        @media (max-width: 1024px) {
            .desktop-nav {
                display: none !important;
            }

            .logo-text {
                font-size: 0.9rem;
                line-height: 1.2;
            }

            .logo-image {
                height: 14px !important;
                width: auto;
            }

            /* Perbaikan tumpang tindih tombol logout dan search bar */
            .header-right-section {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .auth-buttons {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                order: 2;
                /* Mengatur urutan elemen */
            }

            #search-container {
                position: relative;
                order: 1;
                /* Mengatur urutan elemen */
            }

            .mobile-menu-button {
                order: 3;
                /* Mengatur urutan elemen */
            }

            @media (min-width: 1024px) {
                .header-right-section {
                    gap: 1rem;
                    flex-wrap: nowrap;
                }

                .auth-buttons {
                    order: 3;
                }

                #search-container {
                    order: 2;
                }

                .mobile-menu-button {
                    order: 4;
                }
            }

            /* Perbaikan khusus untuk tampilan mobile */
            @media (max-width: 1023px) {
                .auth-buttons {
                    display: none;
                    /* Sembunyikan tombol logout di mobile (sudah ada di menu mobile) */
                }

                #search-container {
                    margin-left: auto;
                    /* Dorong search bar ke kanan */
                }
            }
        }

        @media (min-width: 1024px) {
            .mobile-menu-button {
                display: none !important;
            }
        }

        /* Improved search bar for mobile */
        @media (max-width: 640px) {
            #search-input.active {
                width: 150px;
            }

            .search-toggle {
                margin-left: 0;
            }
        }

        /* KELAS BARU UNTUK MEMAKSA TAMPILAN MOBILE BERDASARKAN ZOOM */
        body.force-mobile-view .desktop-nav,
        body.force-mobile-view .desktop-auth-menu {
            display: none !important;
        }

        body.force-mobile-view .mobile-menu-button {
            display: flex !important;
        }

        /* PERBAIKAN FINAL: Pastikan panel menu mobile juga bisa tampil di layar lebar */
        body.force-mobile-view #mobile-menu-overlay {
            display: block !important;
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen"
    data-user-role="{{ Auth::check() ? (Auth::user()->hasRole(['super-admin', 'admin']) ? 'admin' : 'user') : 'guest' }}">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        {{-- Bar waktu real-time --}}
        <div class="bg-gray-800 text-white text-xs">
            <div class="container mx-auto px-4 sm:px-6 py-1.5 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#FCE405]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span id="realtime-clock">Memuat waktu...</span>
            </div>
        </div>

        {{-- Header utama --}}
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-4">
                {{-- Logo dan nama instansi --}}
                <a href="{{ $logoHomeUrl }}" class="flex items-center space-x-2 sm:space-x-3">
                    <img src="{{ asset('img/logo.png') }}" class="h-12 sm:h-16 w-auto"
                        alt="Logo Pemerintah Kabupaten Subang"
                        onerror="this.onerror=null;this.src='https://placehold.co/80x80/e2e8f0/e2e8f0?text=Logo';">

                    <div class="font-bold text-[#1E4E7C] leading-tight logo-text">
                        <div class="text-xs sm:text-sm">Pemerintah Daerah</div>
                        <div class="text-sm sm:text-xl">
                            @if($isKecamatanContext)
                            Kecamatan {{ $activeKecamatan->name }}
                            @elseif($isPerangkatDaerahContext)
                            {{ $activePerangkatDaerah->name }}
                            @else
                            Kabupaten Subang
                            @endif
                        </div>
                    </div>
                </a>

                {{-- Bagian kanan header: Navigasi, Search, dan Menu Pengguna --}}
                <div class="flex items-center space-x-2 sm:space-x-4 header-right-section">
                    {{-- Navigasi desktop --}}
                    <nav
                        class="hidden xl:flex items-center space-x-3 xl:space-x-4 text-sm font-medium text-gray-500 desktop-nav">
                        <a href="{{ $publicHomeUrl }}"
                            class="nav-link hover:text-[#FF3B00] transition-colors duration-200 whitespace-nowrap">Beranda</a>

                        {{-- Dropdown Profil --}}
                        <div class="relative" data-dropdown>
                            <button
                                class="nav-link dropdown-toggle flex items-center hover:text-[#FF3B00] transition-colors duration-200 whitespace-nowrap">
                                <span>Profil</span>
                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div
                                class="dropdown-menu absolute mt-2 w-48 bg-white rounded-md shadow-xl z-20 py-1 border">
                                <a href="{{ $isKecamatanContext ? route('sejarah.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.sejarah', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('sejarah.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Sejarah</a>
                                <a href="{{ $isKecamatanContext ? route('wilayah.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.wilayah', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('wilayah.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Wilayah</a>
                                <a href="{{ $isKecamatanContext ? route('visimisi.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.visimisi', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('visimisi.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Visi
                                    dan Misi</a>
                                <a href="{{ $isKecamatanContext ? route('penghargaan.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.penghargaan', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('penghargaan.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Penghargaan</a>
                            </div>
                        </div>

                        {{-- Dropdown Pemerintahan --}}
                        <div class="relative" data-dropdown>
                            <button
                                class="nav-link dropdown-toggle flex items-center hover:text-[#FF3B00] transition-colors duration-200 whitespace-nowrap">
                                <span>Pemerintahan</span>
                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div
                                class="dropdown-menu absolute mt-2 w-56 bg-white rounded-md shadow-xl z-20 py-1 border">
                                <a href="{{ $isKecamatanContext ? route('struktur.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.struktur', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('struktur.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Struktur
                                    Pemerintahan</a>
                                <a href="{{ $isKecamatanContext ? route('peran_program.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.peran_program', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('peran_program.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Peran
                                    dan Program</a>
                                <a href="{{ $isKecamatanContext ? route('wilayah_administrasi.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.wilayah_administrasi', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('wilayah_administrasi.kabupaten')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Wilayah
                                    Administrasi</a>
                            </div>
                        </div>

                        {{-- Hanya tampilkan dropdown Wisata jika BUKAN konteks Perangkat Daerah --}}
                        @if(!$isPerangkatDaerahContext)

                        {{-- Dropdown Wisata --}}
                        <div class="relative" data-dropdown>
                            <button
                                class="nav-link dropdown-toggle flex items-center hover:text-[#FF3B00] transition-colors duration-200 whitespace-nowrap">
                                <span>Wisata</span>
                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div
                                class="dropdown-menu absolute mt-2 w-48 bg-white rounded-md shadow-xl z-20 py-1 border">
                                {{-- Logika di dalam link ini sudah benar, tetapi sekarang kita perlu menyederhanakannya
                                karena kita sudah tahu ini bukan konteks Perangkat Daerah --}}
                                <a href="{{ $isKecamatanContext ? route('wisata.senibudaya.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.senibudaya.kabupaten') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Seni
                                    dan Budaya</a>
                                <a href="{{ $isKecamatanContext ? route('wisata.objekwisata.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.objekwisata.kabupaten') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Objek
                                    Wisata</a>
                                <a href="{{ $isKecamatanContext ? route('wisata.hotel.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.hotel.kabupaten') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Hotel</a>
                                <a href="{{ $isKecamatanContext ? route('wisata.rumahmakan.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.rumahmakan.kabupaten') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">Rumah
                                    Makan</a>
                            </div>
                        </div>

                        @endif

                        <a href="{{ $isKecamatanContext ? route('transparansi.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.transparansi', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('transparansi.kabupaten')) }}"
                            class="nav-link hover:text-[#FF3B00] transition-colors duration-200 whitespace-nowrap">Transparansi
                            Keuangan</a>
                        <a href="{{ $isKecamatanContext ? route('infografis.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.infografis', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('infografis.kabupaten')) }}"
                            class="nav-link hover:text-[#FF3B00] transition-colors duration-200 whitespace-nowrap">Infografis</a>
                    </nav>

                    {{-- Search bar --}}
                    <div id="search-container" class="relative flex items-center">
                        <input type="text" id="search-input" placeholder="Cari konten..."
                            class="absolute right-0 rounded-full focus:outline-none focus:ring-2 focus:ring-[#1E4E7C] text-sm">
                        <button id="search-toggle"
                            class="bg-gray-100 p-2 rounded-full ml-2 transition-all duration-300 hover:bg-gray-200 search-toggle"
                            title="Cari konten">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <div id="search-results"
                            class="hidden absolute top-full mt-2 right-0 w-80 bg-white rounded-lg shadow-xl border z-30 search-results">
                        </div>
                    </div>

                    {{-- Menu pengguna (desktop) --}}
                    <div class="hidden xl:flex items-center desktop-auth-menu">
                        @auth
                        <div class="relative" data-dropdown>
                            <button
                                class="dropdown-toggle flex items-center space-x-2 text-sm font-medium text-gray-600 hover:text-[#1E4E7C] transition-colors">
                                <span class="truncate max-w-[150px]">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div
                                class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 py-1 border">
                                <div class="px-4 py-2 text-xs text-gray-400">
                                    Halo, {{ Auth::user()->roles->first()->name ?? 'User' }}
                                </div>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#FF3B00] transition-colors">
                                    <i class="fas fa-tachometer-alt w-5 mr-2"></i>Dashboard
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5 mr-2"></i>Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>

                    {{-- Tombol menu mobile --}}
                    <button id="mobile-menu-button"
                        class="lg:hidden p-2 rounded-md hover:bg-gray-100 transition-colors mobile-menu-button"
                        title="Buka menu navigasi">
                        <div class="hamburger w-6 h-6 flex flex-col justify-center space-y-1">
                            <div class="hamburger-line w-6 h-0.5 bg-gray-600"></div>
                            <div class="hamburger-line w-6 h-0.5 bg-gray-600"></div>
                            <div class="hamburger-line w-6 h-0.5 bg-gray-600"></div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </header>


    {{-- Menu mobile --}}
    <div id="mobile-menu-overlay" class="mobile-menu-overlay fixed inset-0 z-40 lg:hidden">
        <div id="mobile-menu"
            class="mobile-menu fixed top-0 right-0 h-full w-80 bg-white shadow-xl z-50 overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-[#1E4E7C]">Menu Navigasi</h2>
                    <button id="mobile-menu-close" class="p-2 hover:bg-gray-100 rounded-md" title="Tutup menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <nav class="space-y-4">
                    <a href="{{ $publicHomeUrl }}"
                        class="block py-2 text-gray-700 hover:text-[#FF3B00] font-medium transition-colors">
                        <i class="fas fa-home w-5 mr-3"></i>Beranda
                    </a>

                    {{-- Dropdown Profil --}}
                    <div class="mobile-dropdown">
                        <button
                            class="mobile-dropdown-toggle w-full flex items-center justify-between py-2 text-gray-700 hover:text-[#FF3B00] font-medium transition-colors">
                            <span><i class="fas fa-user w-5 mr-3"></i>Profil</span>
                            <svg class="w-4 h-4 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-8 mt-2 space-y-2">
                            <a href="{{ $isKecamatanContext ? route('sejarah.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.sejarah', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('sejarah.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Sejarah</a>
                            <a href="{{ $isKecamatanContext ? route('wilayah.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.wilayah', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('wilayah.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Wilayah</a>
                            <a href="{{ $isKecamatanContext ? route('visimisi.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.visimisi', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('visimisi.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Visi dan
                                Misi</a>
                            <a href="{{ $isKecamatanContext ? route('penghargaan.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.penghargaan', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('penghargaan.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Penghargaan</a>
                        </div>
                    </div>

                    {{-- Dropdown Pemerintahan --}}
                    <div class="mobile-dropdown">
                        <button
                            class="mobile-dropdown-toggle w-full flex items-center justify-between py-2 text-gray-700 hover:text-[#FF3B00] font-medium transition-colors">
                            <span><i class="fas fa-building w-5 mr-3"></i>Pemerintahan</span>
                            <svg class="w-4 h-4 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-8 mt-2 space-y-2">
                            <a href="{{ $isKecamatanContext ? route('struktur.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.struktur', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('struktur.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Struktur
                                Pemerintahan</a>
                            <a href="{{ $isKecamatanContext ? route('peran_program.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.peran_program', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('peran_program.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Peran
                                dan Program</a>
                            <a href="{{ $isKecamatanContext ? route('wilayah_administrasi.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.wilayah_administrasi', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('wilayah_administrasi.kabupaten')) }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Wilayah
                                Administrasi</a>
                        </div>
                    </div>

                    {{-- ====================================================================== --}}
                    {{-- PERBAIKAN DI SINI: Seluruh blok Wisata dibungkus dengan @if --}}
                    {{-- ====================================================================== --}}
                    @if(!$isPerangkatDaerahContext)
                    <div class="mobile-dropdown">
                        <button
                            class="mobile-dropdown-toggle w-full flex items-center justify-between py-2 text-gray-700 hover:text-[#FF3B00] font-medium transition-colors">
                            <span><i class="fas fa-map-marked-alt w-5 mr-3"></i>Wisata</span>
                            <svg class="w-4 h-4 transform transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="mobile-dropdown-menu hidden pl-8 mt-2 space-y-2">
                            <a href="{{ $isKecamatanContext ? route('wisata.senibudaya.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.senibudaya.kabupaten') }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Seni
                                dan Budaya</a>
                            <a href="{{ $isKecamatanContext ? route('wisata.objekwisata.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.objekwisata.kabupaten') }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Objek
                                Wisata</a>
                            <a href="{{ $isKecamatanContext ? route('wisata.hotel.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.hotel.kabupaten') }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Hotel</a>
                            <a href="{{ $isKecamatanContext ? route('wisata.rumahmakan.kecamatan', ['kecamatan' => $kecamatanSlug]) : route('wisata.rumahmakan.kabupaten') }}"
                                class="block py-1 text-sm text-gray-600 hover:text-[#FF3B00] transition-colors">Rumah
                                Makan</a>
                        </div>
                    </div>
                    @endif
                    {{-- ====================================================================== --}}
                    {{-- AKHIR PERBAIKAN --}}
                    {{-- ====================================================================== --}}

                    <a href="{{ $isKecamatanContext ? route('transparansi.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.transparansi', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('transparansi.kabupaten')) }}"
                        class="block py-2 text-gray-700 hover:text-[#FF3B00] font-medium transition-colors">
                        <i class="fas fa-chart-line w-5 mr-3"></i>Transparansi Keuangan
                    </a>
                    <a href="{{ $isKecamatanContext ? route('infografis.kecamatan', ['kecamatan' => $kecamatanSlug]) : ($isPerangkatDaerahContext ? route('perangkat.infografis', ['perangkatDaerah' => $perangkatDaerahSlug]) : route('infografis.kabupaten')) }}"
                        class="block py-2 text-gray-700 hover:text-[#FF3B00] font-medium transition-colors">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>Infografis
                    </a>
                </nav>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    @auth
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Halo, {{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full bg-[#E20E0D] hover:brightness-90 text-white text-sm font-bold py-2 px-4 rounded-lg transition-all duration-300 flex items-center justify-center space-x-2 btn-animate">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>


    <main class="flex-grow mb-12 relative z-10">
        @yield('content')
    </main>

    <footer class="bg-[#1E4E7C] text-white border-t-4 border-yellow-400">
        <div class="container mx-auto px-6 py-16">
            {{-- [MODIFIKASI] Menggunakan grid yang lebih sederhana dan responsif --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-y-10 gap-x-8">

                {{-- Kolom 1: Logo dan Tentang --}}
                <div class="flex flex-col items-center text-center md:items-start md:text-left xl:col-span-1">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ asset('img/logo.png') }}" class="h-14 w-auto" alt="Logo Kabupaten Subang"
                            onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}';">
                        <span class="font-bold text-xl leading-tight">
                            Pemerintah Daerah<br>
                            @if($isKecamatanContext)
                            Kecamatan {{ $activeKecamatan->name }}
                            @elseif($isPerangkatDaerahContext)
                            {{ $activePerangkatDaerah->name }}
                            @else
                            Kabupaten Subang
                            @endif
                        </span>
                    </div>
                    <p class="text-gray-300 text-sm max-w-md leading-relaxed">
                        Portal Digital terintegrasi untuk layanan dan informasi publik.
                    </p>

                    {{-- Ikon sosial media --}}
                    <div class="flex space-x-3 mt-6">
                        @php
                        // [PERBAIKAN] Tentukan satu sumber data yang benar untuk semua link sosial media.
                        // Prioritas: tenant aktif. Jika tidak ada, gunakan data kontak kabupaten.
                        $sosmed = $activeKecamatan ?? $activePerangkatDaerah ?? $kontakKabupaten;
                        @endphp

                        {{-- Facebook --}}
                        @if(isset($sosmed) && $sosmed->link_facebook)
                        <a href="{{ $sosmed->link_facebook }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-full hover:bg-white/20 hover:scale-110 transition-all duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @else
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-white/5 rounded-full cursor-not-allowed"
                            title="Facebook tidak tersedia">
                            <i class="fab fa-facebook-f text-gray-500"></i>
                        </span>
                        @endif

                        {{-- Twitter (X) --}}
                        @if(isset($sosmed) && $sosmed->link_twitter)
                        <a href="{{ $sosmed->link_twitter }}" target="_blank" rel="noopener noreferrer"
                            aria-label="X (Twitter)"
                            class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-full hover:bg-white/20 hover:scale-110 transition-all duration-200">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        @else
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-white/5 rounded-full cursor-not-allowed"
                            title="Twitter (X) tidak tersedia">
                            <i class="fab fa-x-twitter text-gray-500"></i>
                        </span>
                        @endif

                        {{-- YouTube --}}
                        @if(isset($sosmed) && $sosmed->link_youtube)
                        <a href="{{ $sosmed->link_youtube }}" target="_blank" rel="noopener noreferrer"
                            aria-label="YouTube"
                            class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-full hover:bg-white/20 hover:scale-110 transition-all duration-200">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @else
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-white/5 rounded-full cursor-not-allowed"
                            title="YouTube tidak tersedia">
                            <i class="fab fa-youtube text-gray-500"></i>
                        </span>
                        @endif

                        {{-- Instagram --}}
                        @if(isset($sosmed) && $sosmed->link_instagram)
                        <a href="{{ $sosmed->link_instagram }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram"
                            class="w-10 h-10 flex items-center justify-center bg-white/10 rounded-full hover:bg-white/20 hover:scale-110 transition-all duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @else
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-white/5 rounded-full cursor-not-allowed"
                            title="Instagram tidak tersedia">
                            <i class="fab fa-instagram text-gray-500"></i>
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Kolom Link Terkait --}}
                <div class="text-center md:text-left">
                    <h3 class="font-semibold text-base mb-4 uppercase tracking-wider">Link Terkait</h3>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="{{ $isKecamatanContext ? route('agenda.kecamatan', $kecamatanSlug) : ($isPerangkatDaerahContext ? route('perangkat.agenda', $perangkatDaerahSlug) : route('agenda.kabupaten')) }}"
                                class="hover:text-white hover:underline transition-colors">Agenda</a></li>
                        <li><a href="{{ $isKecamatanContext ? route('berita.kecamatan.index', $kecamatanSlug) : ($isPerangkatDaerahContext ? route('perangkat.berita.index', $perangkatDaerahSlug) : route('berita.index')) }}"
                                class="hover:text-white hover:underline transition-colors">Berita</a></li>
                        <li><a href="#" class="hover:text-white hover:underline transition-colors">Pengumuman</a></li>
                        <li><a href="{{ $isKecamatanContext ? route('kecamatan.layanan.index', $kecamatanSlug) : ($isPerangkatDaerahContext ? route('perangkat.layanan.index', $perangkatDaerahSlug) : '#') }}"
                                class="hover:text-white hover:underline transition-colors">Layanan Publik</a></li>
                    </ul>
                </div>

                {{-- Kolom Hubungi Kami --}}
                <div class="text-center md:text-left">
                    <h3 class="font-semibold text-base mb-4 uppercase tracking-wider">Hubungi Kami</h3>

                    @php
                    // [PERBAIKAN] Tentukan sumber data kontak yang benar secara dinamis
                    // Prioritas: tenant aktif. Jika tidak ada, gunakan data kontak kabupaten.
                    $kontak = $activeKecamatan ?? $activePerangkatDaerah ?? $kontakKabupaten;
                    @endphp

                    @if(isset($kontak))
                    <ul class="space-y-4 text-sm text-gray-300">
                        <li class="flex items-start justify-center md:justify-start">
                            <i class="fas fa-phone w-4 mr-3 mt-1 flex-shrink-0 text-gray-400"></i>
                            {{-- [PERBAIKAN] Kode menjadi jauh lebih sederhana --}}
                            <span>{{ $kontak->telepon ?? 'Belum diatur' }}</span>
                        </li>
                        <li class="flex items-start justify-center md:justify-start">
                            <i class="fas fa-envelope w-4 mr-3 mt-1 flex-shrink-0 text-gray-400"></i>
                            <span>{{ $kontak->email ?? 'Belum diatur' }}</span>
                        </li>
                        <li class="flex items-start justify-center md:justify-start">
                            <i class="fas fa-map-marker-alt w-4 mr-3 mt-1 flex-shrink-0 text-gray-400"></i>
                            <span>{{ $kontak->alamat ?? 'Belum diatur' }}</span>
                        </li>
                    </ul>
                    @endif
                </div>

                {{-- Kolom Statistik Pengunjung --}}
                <div class="text-center md:text-left">
                    <h3 class="font-semibold text-base mb-4 uppercase tracking-wider">Statistik</h3>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-users w-4 mr-3 text-gray-400"></i>
                            <span>Online: <strong class="text-white">{{ $visitorStats['online'] ?? '0'
                                    }}</strong></span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-calendar-day w-4 mr-3 text-gray-400"></i>
                            <span>Hari Ini: <strong class="text-white">{{ $visitorStats['today'] ?? '0'
                                    }}</strong></span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-chart-bar w-4 mr-3 text-gray-400"></i>
                            <span>Total: <strong class="text-white">{{ $visitorStats['total'] ?? '0' }}</strong></span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="bg-black/20 py-4">
            <div class="container mx-auto px-6 text-center text-xs text-gray-400">
                <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
                    <span>Hak Cipta © {{ date('Y') }} Pemerintah Kabupaten Subang. Dikelola oleh Diskominfo.</span>
                    {{-- Tambahan Tautan Kebijakan Privasi --}}
                    <span>|</span>
                    <a href="{{ route('privacy.policy') }}" class="hover:text-white transition-colors duration-200">
                        Kebijakan Privasi
                    </a>
                </div>
            </div>
        </div>
    </footer>


    {{-- Cookie banner --}}
    <div x-data="{
        showBanner: !localStorage.getItem('cookieConsent'),
        acceptCookies() {
            localStorage.setItem('cookieConsent', 'accepted');
            this.showBanner = false;
        }
    }" x-show="showBanner" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="transform translate-y-full opacity-0"
        x-transition:enter-end="transform translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform translate-y-0 opacity-100"
        x-transition:leave-end="transform translate-y-full opacity-0"
        class="cookie-banner fixed bottom-0 left-0 right-0 bg-white border-t-2 border-[#1E4E7C] shadow-2xl z-50 p-4 sm:p-6"
        style="display: none;" x-cloak>
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div class="flex items-start space-x-2 sm:space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#1E4E7C]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div class="text-xs sm:text-sm text-gray-700">
                    <p class="font-semibold text-[#1E4E7C] mb-1">Kebijakan Cookie & Privasi</p>
                    <p>Kami menggunakan cookie untuk meningkatkan pengalaman Anda di Portal Resmi Kabupaten Subang.
                        Dengan melanjutkan Browse, Anda menyetujui penggunaan cookie sesuai kebijakan privasi kami.</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                <button @click="acceptCookies()"
                    class="bg-[#1E4E7C] hover:brightness-90 text-white px-4 sm:px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-md btn-animate">
                    <i class="fas fa-check mr-2"></i>Setuju
                </button>
                <a href="#" class="text-[#1E4E7C] hover:underline px-4 py-2 text-xs sm:text-sm font-medium text-center">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Fungsi untuk menampilkan jam waktu nyata ---
            const clockElement = document.getElementById('realtime-clock');
            if (clockElement) {
                function updateClock() {
                    try {
                        const now = new Date();
                        const options = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: false
                        };
                        const formattedTime = now.toLocaleString('id-ID', options).replace(/\./g, ':');
                        clockElement.textContent = formattedTime;
                    } catch (error) {
                        console.warn('Kesalahan saat memperbarui jam:', error);
                        clockElement.textContent = 'Waktu tidak tersedia';
                    }
                }
                setInterval(updateClock, 1000);
                updateClock();
            }

            const bodyElement = document.body;
            const userRole = bodyElement.dataset.userRole || 'guest';

            function handleZoomChange() {
                const bodyElement = document.body;
                const userRole = bodyElement.dataset.userRole || 'guest';
                const currentWidth = window.innerWidth;

                const breakpoint = (userRole === 'admin') ?
                    1280 :
                    (userRole === 'guest' ? 480 : 1024);

                // Jika lebar layar saat ini lebih kecil dari breakpoint, paksa tampilan mobile
                if (currentWidth < breakpoint) {
                    bodyElement.classList.add('force-mobile-view');
                } else {
                    bodyElement.classList.remove('force-mobile-view');
                }
            }

            // Panggil fungsi saat event resize (zoom-in/out memicu resize)
            window.addEventListener('resize', handleZoomChange);

            // Panggil fungsi sekali saat halaman pertama kali dimuat
            handleZoomChange();

            // --- Fungsi pencarian yang diperbaiki dan aman ---
            const searchContainer = document.getElementById('search-container');
            const searchToggle = document.getElementById('search-toggle');
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            let searchTimeout;

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function performSearch(query) {
                if (!query || query.length < 2) {
                    hideSearchResults();
                    return;
                }
                const results = [];
                const queryLower = query.toLowerCase();
                const processedElements = new WeakSet();
                document.querySelectorAll('main h1, main h2, main h3, main p, main a, main li, main td').forEach(element => {
                    if (processedElements.has(element) || element.offsetParent === null) return;
                    const elementText = element.textContent.trim();
                    if (elementText && elementText.toLowerCase().includes(queryLower)) {
                        let context = '';
                        const parentSection = element.closest('section, article');
                        if (parentSection) {
                            const heading = parentSection.querySelector('h1, h2, h3');
                            if (heading && heading !== element) context = heading.textContent.trim();
                        }
                        const highlightIndex = elementText.toLowerCase().indexOf(queryLower);
                        const start = Math.max(0, highlightIndex - 40);
                        const end = Math.min(elementText.length, highlightIndex + query.length + 60);
                        let preview = (start > 0 ? '...' : '') + elementText.substring(start, end) + (end < elementText.length ? '...' : '');
                        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        const regex = new RegExp(`(${escapedQuery})`, 'gi');
                        preview = escapeHtml(preview).replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
                        results.push({
                            element: element,
                            text: preview,
                            context: context
                        });
                        processedElements.add(element);
                        if (results.length >= 7) return;
                    }
                });
                displaySearchResults(results, query);
            }

            function displaySearchResults(results, query) {
                if (results.length === 0) {
                    searchResults.innerHTML = `<div class="p-4 text-center text-gray-500"><p>Tidak ada hasil untuk "${escapeHtml(query)}"</p></div>`;
                } else {
                    searchResults.innerHTML = `<div class="p-2"><div class="text-xs text-gray-500 px-2 pb-1">Menampilkan ${results.length} hasil teratas</div><div class="space-y-1">${results.map((result, index) => `<div class="search-result-item p-3 rounded-lg hover:bg-gray-50 cursor-pointer" data-index="${index}">${result.context ? `<div class="text-xs text-[#1E4E7C] font-semibold mb-1">${escapeHtml(result.context)}</div>` : ''}<div class="text-sm text-gray-700">${result.text}</div></div>`).join('')}</div></div>`;
                    searchResults.querySelectorAll('.search-result-item').forEach((item, index) => {
                        item.addEventListener('click', () => {
                            const result = results[index];
                            result.element.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            highlightFoundElement(result.element);
                            hideSearchResults();
                            closeMobileMenu();
                        });
                    });
                }
                showSearchResults();
            }

            function highlightFoundElement(element) {
                const originalBg = element.style.backgroundColor;
                element.style.transition = 'background-color 0.5s ease';
                element.style.backgroundColor = '#FEF3C7';
                setTimeout(() => {
                    element.style.backgroundColor = originalBg;
                }, 3000);
            }

            function showSearchResults() {
                searchResults.classList.remove('hidden');
                searchResults.style.opacity = '0';
                searchResults.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    searchResults.style.opacity = '1';
                    searchResults.style.transform = 'translateY(0)';
                }, 10);
            }

            function hideSearchResults() {
                searchResults.style.opacity = '0';
                searchResults.style.transform = 'translateY(-10px)';
                setTimeout(() => searchResults.classList.add('hidden'), 200);
            }

            const debouncedSearch = (query) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => performSearch(query), 300);
            };

            if (searchInput) {
                searchInput.addEventListener('input', () => debouncedSearch(searchInput.value));
            }

            searchToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                searchInput.classList.toggle('active');
                if (searchInput.classList.contains('active')) {
                    searchInput.focus();
                } else {
                    hideSearchResults();
                }
            });

            // Tutup hasil pencarian saat klik di luar
            document.addEventListener('click', function (e) {
                if (!searchContainer.contains(e.target)) {
                    searchInput.classList.remove('active');
                    hideSearchResults();
                }
            });

            // --- Fungsionalitas menu mobile ---
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const hamburger = document.querySelector('.hamburger');

            function openMobileMenu() {
                mobileMenuOverlay.classList.add('active');
                mobileMenu.classList.add('active');
                hamburger.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                mobileMenuOverlay.classList.remove('active');
                mobileMenu.classList.remove('active');
                hamburger.classList.remove('active');
                document.body.style.overflow = '';
            }

            mobileMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                openMobileMenu();
            });

            mobileMenuClose.addEventListener('click', closeMobileMenu);

            mobileMenuOverlay.addEventListener('click', (e) => {
                if (e.target === mobileMenuOverlay) closeMobileMenu();
            });

            document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const menu = this.nextElementSibling;
                    const icon = this.querySelector('svg');
                    menu.classList.toggle('hidden');
                    icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                });
            });

            // =======================================================================
            // PERBAIKAN UTAMA: LOGIKA DROPDOWN DESKTOP BERBASIS KLIK YANG LEBIH BAIK
            // =======================================================================

            // 1. Tambahkan event listener ke setiap tombol dropdown
            document.querySelectorAll('[data-dropdown]').forEach(dropdownContainer => {
                const toggleButton = dropdownContainer.querySelector('.dropdown-toggle');
                const menu = dropdownContainer.querySelector('.dropdown-menu');

                toggleButton.addEventListener('click', function (event) {
                    // Mencegah link default dan menghentikan event agar tidak langsung ditangapi oleh document
                    event.preventDefault();
                    event.stopPropagation();

                    const isCurrentlyOpen = menu.classList.contains('show');

                    // Pertama, tutup semua dropdown lain yang mungkin sedang terbuka
                    document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                        openMenu.classList.remove('show');
                    });

                    // Jika dropdown yang diklik tadi belum terbuka, maka buka sekarang.
                    // Jika sudah terbuka, langkah di atas sudah menutupnya.
                    if (!isCurrentlyOpen) {
                        menu.classList.add('show');
                    }
                });
            });

            // 2. Tambahkan satu event listener global untuk menutup dropdown saat klik di luar area
            document.addEventListener('click', function (event) {
                // Jika target klik BUKAN di dalam sebuah container dropdown...
                if (!event.target.closest('[data-dropdown]')) {
                    // ...maka tutup semua dropdown yang sedang terbuka.
                    document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                        openMenu.classList.remove('show');
                    });
                }
            });

            // Event listener untuk tombol 'Escape'
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    hideSearchResults();
                    closeMobileMenu();
                    // Tutup juga semua dropdown desktop yang terbuka
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
                }
            });

            // Event listener untuk resize window
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) closeMobileMenu();
            });

            console.log('Portal Kabupaten Subang - Skrip berhasil diinisialisasi dengan perbaikan dropdown.');
        });
    </script>
    @stack('scripts')
    @stack('scripts-footer')
</body>

</html>