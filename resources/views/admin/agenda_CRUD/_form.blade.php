@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }

    .trix-content {
        min-height: 150px;
        border-color: #d1d5db;
        border-radius: 0.375rem;
        background-color: white;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .trix-content:focus {
        border-color: #1E4E7C;
        box-shadow: 0 0 0 1px #1E4E7C;
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush


@csrf
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
    <p class="font-bold">Terjadi Kesalahan</p>
    <ul class="mt-2 list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="space-y-6">
    @if(auth()->user()->hasRole('super-admin'))
    @php
    $ownerType = 'kabupaten';
    if (old('owner_type')) {
    $ownerType = old('owner_type');
    } elseif ($agenda->perangkat_daerah_id) {
    $ownerType = 'pd';
    } elseif ($agenda->kecamatan_id) {
    $ownerType = 'kecamatan';
    }
    @endphp
    <div x-data="{ owner_type: '{{ $ownerType }}' }">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pemilik Agenda <span
                class="text-red-500">*</span></label>
        <div class="flex space-x-4 mb-4">
            <label class="flex items-center"><input type="radio" x-model="owner_type" name="owner_type"
                    value="kabupaten" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span
                    class="ml-2 text-sm text-gray-700">Kabupaten</span></label>
            <label class="flex items-center"><input type="radio" x-model="owner_type" name="owner_type"
                    value="kecamatan" class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span
                    class="ml-2 text-sm text-gray-700">Kecamatan</span></label>
            <label class="flex items-center"><input type="radio" x-model="owner_type" name="owner_type" value="pd"
                    class="focus:ring-[#1E4E7C] h-4 w-4 text-[#1E4E7C] border-gray-300"><span
                    class="ml-2 text-sm text-gray-700">Perangkat Daerah</span></label>
        </div>
        <div x-show="owner_type === 'kecamatan'" x-transition>
            <select name="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($kecamatans as $kec)
                <option value="{{ $kec->id }}" @selected(old('kecamatan_id', $agenda->kecamatan_id) == $kec->id)>{{
                    $kec->name }}</option>
                @endforeach
            </select>
        </div>
        <div x-show="owner_type === 'pd'" x-transition>
            <select name="perangkat_daerah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($perangkatDaerahs as $pd)
                <option value="{{ $pd->id }}" @selected(old('perangkat_daerah_id', $agenda->perangkat_daerah_id) ==
                    $pd->id)>{{ $pd->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Agenda <span
                class="text-red-500">*</span></label>
        <input type="text" name="judul" id="judul" value="{{ old('judul', $agenda->judul ?? '') }}" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai <span
                    class="text-red-500">*</span></label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                value="{{ old('tanggal_mulai', $agenda->tanggal_mulai ? \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('Y-m-d') : '') }}"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
        </div>
        <div>
            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai
                (Opsional)</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                value="{{ old('tanggal_selesai', $agenda->tanggal_selesai ? \Carbon\Carbon::parse($agenda->tanggal_selesai)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#1E4E7C] focus:border-[#1E4E7C]">
        </div>
    </div>
    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
        <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $agenda->deskripsi ?? '') }}">
        <trix-editor input="deskripsi" class="trix-content mt-1"></trix-editor>
    </div>
</div>
<div class="mt-8 flex justify-end space-x-4">
    <a href="{{ $backRouteUrl }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg">Batal</a>
    <button type="submit" class="bg-[#1E4E7C] hover:brightness-90 text-white font-bold py-2 px-6 rounded-lg">Simpan
        Agenda</button>
</div>