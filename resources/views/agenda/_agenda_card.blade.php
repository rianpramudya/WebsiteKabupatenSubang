<div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-lg transition-shadow duration-300 border border-gray-100">
    <div class="flex flex-col sm:flex-row items-start gap-4">
        {{-- Info Tanggal --}}
        <div class="flex-shrink-0 w-full sm:w-40 text-center sm:text-left mb-3 sm:mb-0 sm:border-r sm:pr-4">
            <div class="text-lg font-bold text-[#1E4E7C]">
                {{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->translatedFormat('d F') }}
            </div>
            <div class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($agenda->tanggal_mulai)->translatedFormat('Y') }}
            </div>
            <div class="text-xs text-gray-500 mt-1">
                <i class="fas fa-clock mr-1"></i>
                {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} WIB
            </div>
        </div>

        {{-- Info Detail Agenda --}}
        <div class="pl-0 sm:pl-4 flex-grow">
            <h3 class="text-xl font-bold text-gray-800">{{ $agenda->judul }}</h3>
            <p class="text-gray-600 mt-1">{{ strip_tags(html_entity_decode($agenda->deskripsi)) }}</p>
            @if($agenda->lokasi)
            <p class="text-sm text-gray-500 mt-2">
                <i class="fas fa-map-marker-alt mr-2"></i><strong>Lokasi:</strong> {{ $agenda->lokasi }}
            </p>
            @endif
        </div>
    </div>
</div>