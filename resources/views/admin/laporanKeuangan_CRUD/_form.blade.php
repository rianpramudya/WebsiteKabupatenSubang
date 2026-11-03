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
        border-color: #4f46e5;

        box-shadow: 0 0 0 1px #4f46e5;
    }
</style>
@endpush

@push('scripts')

<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush

@csrf
<div class="bg-white shadow-xl rounded-lg">
    <div class="p-6 sm:p-8 space-y-6">

        <div>
            <label for="judul_laporan" class="block text-sm font-medium text-gray-700">Judul Laporan <span
                    class="text-red-500">*</span></label>
            <input type="text" name="judul_laporan" id="judul_laporan"
                value="{{ old('judul_laporan', $laporanKeuangan->judul_laporan ?? '') }}" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('judul_laporan') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
            <input id="deskripsi_singkat" type="hidden" name="deskripsi_singkat"
                value="{{ old('deskripsi_singkat', $laporanKeuangan->deskripsi_singkat ?? '') }}">
            <trix-editor input="deskripsi_singkat" class="mt-1 trix-content"></trix-editor>
            @error('deskripsi_singkat') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun Anggaran <span
                        class="text-red-500">*</span></label>
                <input type="number" name="tahun" id="tahun"
                    value="{{ old('tahun', $laporanKeuangan->tahun ?? date('Y')) }}" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('tahun') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="jenis_laporan" class="block text-sm font-medium text-gray-700">Jenis Laporan <span
                        class="text-red-500">*</span></label>
                <select name="jenis_laporan" id="jenis_laporan" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <option value="">Pilih Jenis Laporan</option>
                    @php $jenis = ['Realisasi Anggaran', 'Pertanggungjawaban', 'Pendapatan dan Belanja Tahunan'];
                    @endphp
                    @foreach ($jenis as $j)
                    <option value="{{ $j }}" @selected(old('jenis_laporan', $laporanKeuangan->jenis_laporan ?? '') ==
                        $j)>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_laporan') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="file_laporan" class="block text-sm font-medium text-gray-700">File Laporan <span
                    class="text-red-500">{{ isset($laporanKeuangan->id) ? '' : '*' }}</span></label>
            <input type="file" name="file_laporan" id="file_laporan"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, XLS, XLSX. Maks: 10MB.</p>
            @if(isset($laporanKeuangan->id) && $laporanKeuangan->file_url)
            <p class="mt-1 text-xs text-green-600">File saat ini: <a
                    href="{{ asset('storage/' . $laporanKeuangan->file_url) }}" target="_blank"
                    class="font-medium hover:underline">Lihat File</a></p>
            @endif
            @error('file_laporan') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end items-center space-x-4">

        <a href="{{ route($routePrefix . '.index', $routeParameters) }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors">Batal</a>
        <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-md">
            <i class="fas fa-save mr-2"></i>
            Simpan {{ isset($laporanKeuangan->id) ? 'Perubahan' : '' }}
        </button>
    </div>
</div>