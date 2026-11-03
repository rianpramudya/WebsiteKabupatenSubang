<aside class="lg:col-span-1 space-y-6">
    <div class="bg-white p-5 rounded-lg shadow-sm sticky top-24 anim-fade-in-right" style="--anim-delay: 600ms;">
        <h3 class="font-bold text-lg border-b pb-3 mb-4 text-[#1E4E7C]">Berita Terkini</h3>

        @if(isset($berita_terkini) && $berita_terkini->isNotEmpty())
            <ul class="space-y-4">
                @foreach ($berita_terkini as $berita)
                    <li class="anim-fade-in-up" style="--anim-delay: {{ 700 + ($loop->iteration * 150) }}ms;">

                        <a href="{{ route('berita.show', $berita->slug) }}" class="flex items-center gap-4 group">
                            <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://placehold.co/150x150/e2e8f0/64748b?text=Berita' }}"
                                alt="{{ $berita->judul }}"
                                class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800 group-hover:text-[#FF3B00] leading-tight transition-colors">
                                    {{ Str::limit($berita->judul, 55) }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($berita->published_at)->diffForHumans() }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-400 text-center py-4 anim-fade-in-up" style="--anim-delay: 700ms;">
                Belum ada berita terkini.
            </p>
        @endif
    </div>
</aside>