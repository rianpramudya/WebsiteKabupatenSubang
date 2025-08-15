@extends('layouts.app')
@section('title', 'Kelola Layanan Publik')

@section('content')
{{-- Menambahkan ID unik untuk target animasi --}}
<div id="page-content" class="container mx-auto px-4 py-10">
    @php
    // [PERBAIKAN] Membuat judul halaman dan link 'Tambah' menjadi dinamis
    $pageTitle = 'Kelola Layanan Publik';
    $createUrl = '#';
    $tenantContext = $kecamatan ?? $perangkatDaerah ?? null;

    if ($tenantContext) {
    if ($tenantContext instanceof \App\Models\Kecamatan) {
    $pageTitle .= ' Kecamatan ' . $tenantContext->name;
    $createUrl = route('admin.kecamatan.layanan.create', ['kecamatan' => $tenantContext->slug]);
    } elseif ($tenantContext instanceof \App\Models\PerangkatDaerah) {
    $pageTitle .= ' ' . $tenantContext->name;
    $createUrl = route('admin.perangkat-daerah.layanan.create', ['perangkatDaerah' => $tenantContext->slug]);
    }
    }
    @endphp

    <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#1E4E7C]">{{ $pageTitle }}</h1>
        {{-- Tombol ini sekarang menggunakan URL yang dinamis --}}
        <a href="{{ $createUrl }}"
            class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-4 rounded-lg flex items-center mt-4 sm:mt-0">
            <i class="fas fa-plus mr-2"></i> Tambah Layanan
        </a>
    </div>

    @if (session('success'))
    <div class="bg-[#1E4E7C]/10 border-l-4 border-[#1E4E7C] text-[#1E4E7C] p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Layanan</th>
                        {{-- [PERBAIKAN] Kolom pemilik untuk Super Admin --}}
                        @if(auth()->user()->hasRole('super-admin'))
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pemilik</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link
                            URL</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($layanans as $layanan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $layanan->urutan }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $layanan->nama }}</div>
                            <div class="text-sm text-gray-500">{{
                                Str::limit(strip_tags(html_entity_decode($layanan->deskripsi)), 80) }}</div>
                        </td>
                        {{-- [PERBAIKAN] Menampilkan nama pemilik yang benar --}}
                        @if(auth()->user()->hasRole('super-admin'))
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $layanan->kecamatan->name ??
                            $layanan->perangkatDaerah->name ?? 'N/A' }}</td>
                        @endif
                        <td class="px-6 py-4 text-sm max-w-sm">
                            @if($layanan->link_url)
                            <a href="{{ $layanan->link_url }}" target="_blank"
                                class="text-blue-600 hover:underline block truncate" title="{{ $layanan->link_url }}">
                                {{ $layanan->link_url }}
                            </a>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end space-x-4">
                                {{-- [PERBAIKAN BESAR] Membuat link Aksi menjadi dinamis --}}
                                @php
                                $layananTenant = $layanan->kecamatan ?? $layanan->perangkatDaerah;
                                $editUrl = '#';
                                $destroyUrl = '#';

                                if ($layananTenant) {
                                if ($layananTenant instanceof \App\Models\Kecamatan) {
                                $editUrl = route('admin.kecamatan.layanan.edit', ['kecamatan' => $layananTenant->slug, 'layanan'
                                => $layanan]);
                                $destroyUrl = route('admin.kecamatan.layanan.destroy', ['kecamatan' => $layananTenant->slug,
                                'layanan' => $layanan]);
                                } elseif ($layananTenant instanceof \App\Models\PerangkatDaerah) {
                                $editUrl = route('admin.perangkat-daerah.layanan.edit', ['perangkatDaerah' =>
                                $layananTenant->slug, 'layanan' => $layanan]);
                                $destroyUrl = route('admin.perangkat-daerah.layanan.destroy', ['perangkatDaerah' =>
                                $layananTenant->slug, 'layanan' => $layanan]);
                                }
                                }
                                @endphp
                                @can('update', $layanan)
                                <a href="{{ $editUrl }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800">Edit</a>
                                @endcan
                                @can('delete', $layanan)
                                <form action="{{ $destroyUrl }}" method="POST"
                                    onsubmit="return confirm('Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-semibold text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->hasRole('super-admin') ? '5' : '4' }}"
                            class="px-6 py-12 text-center text-gray-500">Belum ada data layanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- [DITAMBAHKAN] Blok CSS dan JavaScript untuk animasi --}}
<style>
    /* Keyframes untuk animasi fade-in dan fade-out */
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
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                if (link.closest('form[onsubmit]')) {
                    return;
                }
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