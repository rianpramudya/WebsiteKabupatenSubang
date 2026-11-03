@extends('layouts.app')
@section('title', 'Edit Layanan')

@section('content')
<div id="page-content" class="container mx-auto px-4 py-8">
    @php
    $tenant = $layanan->kecamatan ?? $layanan->perangkatDaerah;
    $pageTitle = 'Edit Layanan: ' . $layanan->nama;
    $backUrl = '#';
    $formActionUrl = '#';

    if ($tenant) {
    if ($tenant instanceof \App\Models\Kecamatan) {
    $backUrl = route('admin.kecamatan.layanan.index', ['kecamatan' => $tenant->slug]);
    $formActionUrl = route('admin.kecamatan.layanan.update', ['kecamatan' => $tenant->slug, 'layanan' => $layanan]);
    } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
    $backUrl = route('admin.perangkat-daerah.layanan.index', ['perangkatDaerah' => $tenant->slug]);
    $formActionUrl = route('admin.perangkat-daerah.layanan.update', ['perangkatDaerah' => $tenant->slug, 'layanan' =>
    $layanan]);
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
            @method('PUT')

            @include('admin.layanan_CRUD._form', [
            'layanan' => $layanan,
            'kecamatan' => $layanan->kecamatan,
            'perangkatDaerah' => $layanan->perangkatDaerah,
            'kecamatans' => $kecamatans ?? collect(),
            'perangkatDaerahs' => $perangkatDaerahs ?? collect()
            ])
        </form>
    </div>
</div>

<style>

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(10px);
        }
    }

    #page-content {
        animation: fadeIn 0.5s ease-out forwards;
    }

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