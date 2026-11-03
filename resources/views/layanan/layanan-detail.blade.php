@extends('layouts.app')

@section('title', $layanan->nama)

@push('styles')

<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
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

    .trix-content h1 {
        font-size: 1.5em;
    }

    .trix-content a {
        color: #1E4E7C;
        text-decoration: underline;
    }

    .trix-content ul,
    .trix-content ol {
        margin-left: 1.5rem;
    }
</style>
@endpush

@section('content')

<div id="page-content">
    <main>
        <div class="container mx-auto px-4 py-8 md:py-12">
            <article class="prose lg:prose-xl max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-md">

                <div class="flex flex-col sm:flex-row items-center gap-6 mb-6 not-prose">

                    @if($layanan->icon)
                    <div
                        class="flex-shrink-0 bg-[#1E4E7C]/10 text-[#1E4E7C] w-24 h-24 rounded-full flex items-center justify-center">
                        <i class="{{ $layanan->icon }} text-5xl"></i>
                    </div>
                    @endif

                    <div class="flex-grow text-center sm:text-left">

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $layanan->nama }}</h1>
                    </div>
                </div>

                <div class="text-sm text-gray-500 mb-8 border-b border-t pt-4 pb-4">
                    @if($layanan->kecamatan)
                    <span>Layanan oleh: <strong>Kecamatan {{ $layanan->kecamatan->name }}</strong></span>
                    @endif
                    <span class="mx-2">|</span>
                    <span>Diperbarui pada: {{ $layanan->updated_at->format('d F Y') }}</span>
                </div>

                <div class="trix-content">
                    {!! $layanan->deskripsi !!}
                </div>

                @if($layanan->link_url)
                <div class="mt-8 pt-8 border-t text-center not-prose">
                    <a href="{{ $layanan->link_url }}" target="_blank" rel="noopener noreferrer"
                        class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Kunjungi Situs Layanan
                    </a>
                </div>
                @endif

                <div class="mt-12 text-center not-prose">
                    @php
                    $owner = $layanan->kecamatan ?? $layanan->perangkatDaerah;

                    if ($owner instanceof \App\Models\Kecamatan) {
                    $backRouteName = 'kecamatan.layanan.index';
                    $backRouteParams = ['kecamatan' => $owner->slug];
                    } elseif ($owner instanceof \App\Models\PerangkatDaerah) {
                    $backRouteName = 'perangkat.layanan.index'; // Pastikan nama rute ini benar
                    $backRouteParams = ['perangkatDaerah' => $owner->slug];
                    }
                    @endphp

                    @if(isset($backRouteName))
                    <a href="{{ route($backRouteName, $backRouteParams) }}"
                        class="text-sm font-semibold text-[#1E4E7C] hover:text-[#FF3B00] transition group">
                        <span class="group-hover:-translate-x-1 inline-block transition-transform">&larr;</span> Kembali
                        ke Daftar Layanan
                    </a>
                    @endif
                </div>

            </article>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fadeOutDuration = 500;
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');

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