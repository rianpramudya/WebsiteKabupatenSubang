
@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
    .trix-content { min-height: 200px; font-size: 0.875rem; }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg></div>
            <div class="ml-3"><h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3><div class="mt-2 text-sm text-red-700"><ul role="list" class="list-disc space-y-1 pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
        </div>
    </div>
@endif

<div class="space-y-8">

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Informasi Dasar Layanan</h3>
        <div class="space-y-6">

            @if(auth()->user()->hasRole('super-admin'))
            <div x-data="{ owner_type: '{{ old('owner_type', $layanan->perangkat_daerah_id ? 'pd' : ($layanan->kecamatan_id ? 'kecamatan' : '')) }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pemilik Layanan <span class="text-red-500">*</span></label>
                <div class="flex space-x-4 mb-4">
                    <label class="flex items-center"><input type="radio" x-model="owner_type" name="owner_type" value="kecamatan" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span class="ml-2 text-sm text-gray-700">Kecamatan</span></label>
                    <label class="flex items-center"><input type="radio" x-model="owner_type" name="owner_type" value="pd" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span class="ml-2 text-sm text-gray-700">Perangkat Daerah</span></label>
                </div>
                <div x-show="owner_type === 'kecamatan'" x-transition>
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Pilih Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                        <option value="">-- Tidak ada --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" @selected(old('kecamatan_id', $layanan->kecamatan_id) == $kec->id)>{{ $kec->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div x-show="owner_type === 'pd'" x-transition>
                    <label for="perangkat_daerah_id" class="block text-sm font-medium text-gray-700">Pilih Perangkat Daerah</label>
                    <select name="perangkat_daerah_id" id="perangkat_daerah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
                        <option value="">-- Tidak ada --</option>
                        @foreach($perangkatDaerahs as $pd)
                            <option value="{{ $pd->id }}" @selected(old('perangkat_daerah_id', $layanan->perangkat_daerah_id) == $pd->id)>{{ $pd->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @else

                @php $tenant = $kecamatan ?? $perangkatDaerah; @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pemilik Layanan</label>
                    <input type="text" value="{{ $tenant->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 sm:text-sm" disabled>
                </div>
            @endif

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Layanan <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $layanan->nama ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required placeholder="Contoh: Pendaftaran Kartu Keluarga (KK) Baru">
            </div>

            <div>
                <label for="link_url" class="block text-sm font-medium text-gray-700">Link Eksternal (Opsional)</label>
                <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $layanan->link_url ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" placeholder="https://pelayanan.dukcapil.go.id">
                <p class="mt-2 text-xs text-gray-500">Isi jika layanan ini memiliki halaman atau link pendaftaran sendiri.</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Deskripsi / Isi Halaman Detail <span class="text-red-500">*</span></h3>
        <div>
            <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $layanan->deskripsi ?? '') }}">
            <trix-editor input="deskripsi" class="trix-content mt-1"></trix-editor>
            <p class="mt-2 text-xs text-gray-500">Konten ini akan menjadi isi dari halaman detail layanan jika tidak ada Link Eksternal.</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Pengaturan Tambahan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700">Ikon (Opsional)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', $layanan->icon ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" placeholder="Contoh: fas fa-id-card">
                <p class="mt-2 text-xs text-gray-500">Gunakan class dari <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline">Font Awesome</a> (contoh: `fas fa-id-card`).</p>
            </div>
            <div>
                <label for="urutan" class="block text-sm font-medium text-gray-700">Nomor Urut <span class="text-red-500">*</span></label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $layanan->urutan ?? '0') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C] sm:text-sm" required>
                <p class="mt-2 text-xs text-gray-500">Angka lebih kecil akan tampil lebih dulu.</p>
            </div>
        </div>
    </div>
</div>

<div class="flex items-center justify-end mt-8 pt-5 border-t border-gray-200 space-x-3">

    @php
        $cancelUrl = '#';
        $tenant = $kecamatan ?? $perangkatDaerah;
        if ($tenant) {
            if ($tenant instanceof \App\Models\Kecamatan) {
                $cancelUrl = route('admin.kecamatan.layanan.index', ['kecamatan' => $tenant->slug]);
            } elseif ($tenant instanceof \App\Models\PerangkatDaerah) {
                $cancelUrl = route('admin.perangkat-daerah.layanan.index', ['perangkatDaerah' => $tenant->slug]);
            }
        }
    @endphp
    <a href="{{ $cancelUrl }}" class="bg-white hover:bg-gray-50 text-gray-800 font-semibold py-2 px-4 rounded-lg border border-gray-300 transition-colors">Batal</a>
    <button type="submit" class="bg-[#1E4E7C] hover:bg-[#163a5f] text-white font-bold py-2 px-4 rounded-lg transition-colors">
        <i class="fas fa-save mr-2"></i>{{ $layanan->exists ? 'Simpan Perubahan' : 'Buat Layanan' }}
    </button>
</div>
