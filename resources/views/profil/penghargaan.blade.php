@extends('layouts.app')

@section('title', 'Penghargaan - ' . $nama_wilayah)

@push('styles')
<style>
    .animated-fade {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .animated-fade.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 sm:px-6">

        {{-- Judul Halaman --}}
        <div class="bg-white rounded-lg shadow-md p-6 text-left mb-10 border-l-8 border-sky-500 animated-fade">
            <h1 class="text-3xl font-bold text-gray-800">Penghargaan</h1>
            <p class="mt-1 text-lg text-gray-500">{{ $nama_wilayah }}</p>
        </div>

        {{-- Tabel Penghargaan --}}
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8 animated-fade">
            @if($penghargaan_per_tahun->isEmpty())
                <div class="text-center text-gray-500 py-10">
                    <p>Belum ada data penghargaan yang ditampilkan untuk wilayah ini.</p>
                </div>
            @else
                <div class="space-y-12">
                    @foreach($penghargaan_per_tahun as $tahun => $penghargaans)
                        <div class="animated-fade">
                            {{-- Tahun sebagai sub-judul --}}
                            <h3 class="text-2xl font-bold text-sky-700 mb-4">{{ $tahun }}</h3>
                            
                            {{-- Kontainer tabel dengan overflow agar responsif --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left text-sm">
                                    <thead class="bg-gray-100 border-b">
                                        <tr>
                                            <th class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider w-16">No</th>
                                            <th class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider">Nama Penghargaan</th>
                                            <th class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider">Tingkat</th>
                                            <th class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider">Instansi Pemberi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($penghargaans as $index => $penghargaan)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $penghargaan->nama_penghargaan }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $penghargaan->tingkat }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $penghargaan->instansi_pemberi }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.animated-fade');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    items.forEach((item, index) => {
        item.style.transitionDelay = `${index * 0.2}s`;
        observer.observe(item);
    });
});
</script>
@endpush
