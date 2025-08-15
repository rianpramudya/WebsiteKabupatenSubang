@extends('layouts.app')
@section('title', 'Tambah Layanan Baru')

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    @php
        // [PERBAIKAN] Membuat judul halaman dan link menjadi dinamis
        $tenant = $kecamatan ?? $perangkatDaerah;
        $pageTitle = 'Tambah Layanan Baru';
        $backUrl = '#';
        $formActionUrl = '#';

        if ($tenant) {
            if ($tenant instanceof \App\Models\Kecamatan) {
                $pageTitle .= ' untuk Kecamatan ' . $tenant->name;
                $backUrl = route('admin.kecamatan.layanan.index', ['kecamatan' => $tenant->slug]);
                $formActionUrl = route('admin.kecamatan.layanan.store', ['kecamatan' => $tenant->slug]);
            } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
                $pageTitle .= ' untuk ' . $tenant->name;
                $backUrl = route('admin.perangkat-daerah.layanan.index', ['perangkatDaerah' => $tenant->slug]);
                $formActionUrl = route('admin.perangkat-daerah.layanan.store', ['perangkatDaerah' => $tenant->slug]);
            }
        }
    @endphp

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold leading-tight">{{ $pageTitle }}</h2>
        <a href="{{ $backUrl }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Daftar</a>
    </div>
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-md">
        <form action="{{ $formActionUrl }}" method="POST">
            @csrf
            {{-- [PERBAIKAN] Meneruskan semua variabel yang dibutuhkan oleh _form --}}
            @include('admin.layanan_CRUD._form', [
                'layanan' => new \App\Models\Layanan(),
                'kecamatan' => $kecamatan ?? null,
                'perangkatDaerah' => $perangkatDaerah ?? null,
                'kecamatans' => $kecamatans ?? collect(),
                'perangkatDaerahs' => $perangkatDaerahs ?? collect()
            ])
        </form>
    </div>
</div>

{{-- [DITAMBAHKAN] Blok CSS dan JavaScript untuk animasi --}}
<style>
    /* Keyframes untuk animasi fade-in dan fade-out */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(10px); }
    }

    /* Terapkan animasi fade-in saat halaman dimuat */
    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Terapkan animasi fade-out saat body memiliki kelas 'fading-out' */
    body.fading-out #page-content {
        animation: fadeOut 0.5s ease-out forwards;
    }
</style>

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
@endsection