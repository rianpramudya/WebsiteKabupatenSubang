@extends('layouts.app')

@php
$namaKonteks = 'Kabupaten Subang'; // Default
if (isset($currentPerangkatDaerah)) {
$namaKonteks = $currentPerangkatDaerah->name;
} elseif (isset($currentKecamatan)) {
$namaKonteks = 'Kecamatan ' . $currentKecamatan->name;
}
@endphp
@section('title', 'Wilayah Administrasi - ' . $namaKonteks)

@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .fade-in-left {
        opacity: 0;
        animation: fadeInLeft 0.7s ease-out forwards;
        animation-delay: var(--row-delay, 0ms);
    }

    .fade-in-right {
        opacity: 0;
        animation: fadeInRight 0.7s ease-out forwards;
        animation-delay: var(--row-delay, 0ms);
    }
</style>
@endpush

@section('content')
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1E4E7C] tracking-tight">Wilayah Administrasi</h1>
            <p class="mt-2 text-lg md:text-xl text-gray-500">{{ $namaKonteks }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600 fade-in-up">
                    {{-- [PERBAIKAN] Logika diubah agar bisa menampilkan data untuk semua konteks --}}
                    @if($is_kabupaten)
                    {{-- Tampilan untuk tingkat Kabupaten --}}
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Nama Kecamatan</th>
                            <th scope="col" class="px-6 py-4 text-center">Jumlah Desa/Kelurahan</th>
                            <th scope="col" class="px-6 py-4 text-right">Total Penduduk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($list_data as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <a href="{{ route('kecamatan.show', $item->slug) }}"
                                    class="hover:text-[#FF3B00] hover:underline">
                                    Kecamatan {{ $item->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">{{ $item->wilayah_administrasi_count }}</td>
                            <td class="px-6 py-4 text-right">{{ number_format($item->total_penduduk, 0, ',', '.') }}
                                Jiwa</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">Data kecamatan belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @else
                    {{-- Tampilan untuk Tingkat Kecamatan DAN Perangkat Daerah --}}
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Nama Desa/Kelurahan</th>
                            <th scope="col" class="px-6 py-4">Kepala Desa/Lurah</th>
                            <th scope="col" class="px-6 py-4">Luas Wilayah</th>
                            <th scope="col" class="px-6 py-4 text-right">Jumlah Penduduk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($list_data as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $item->nama_desa }}</td>
                            <td class="px-6 py-4">{{ $item->kepala_desa ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->luas_wilayah ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">{{ $item->jumlah_penduduk ?
                                number_format($item->jumlah_penduduk, 0, ',', '.') . ' Jiwa' : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Data wilayah administrasi untuk
                                wilayah ini belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection