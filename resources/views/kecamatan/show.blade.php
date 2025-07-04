{{-- Menggunakan layout utama yang sama dengan halaman beranda agar tema visual konsisten --}}
@extends('layouts.app')

{{-- Menetapkan judul halaman secara dinamis sesuai nama kecamatan yang diklik --}}
@section('title', 'Kecamatan ' . $kecamatan->name . ' - Portal Kabupaten Subang')

@push('styles')
<style>
/* === DEFINISI ANIMASI (dapat disatukan di app.blade.php jika sering digunakan) === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* === KELAS HELPER ANIMASI === */
.anim-fade-in-up {
    opacity: 0;
    animation: fadeInUp 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in-down {
    opacity: 0;
    animation: fadeInDown 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in-left {
    opacity: 0;
    animation: fadeInLeft 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-fade-in-right {
    opacity: 0;
    animation: fadeInRight 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
.anim-scale-in {
    opacity: 0;
    animation: scaleIn 0.7s ease-out forwards;
    animation-delay: var(--anim-delay, 0ms);
}
</style>
@endpush


{{-- Memulai bagian konten yang akan disisipkan ke dalam layout --}}
@section('content')

<div class="container mx-auto px-4 sm:px-6 py-10">
    
    {{-- Banner Judul Halaman Kecamatan --}}
    <div class="bg-white rounded-lg shadow-lg p-6 text-center mb-10 border-t-4 border-green-500 anim-fade-in-down" style="--anim-delay: 200ms;">
        <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Kecamatan {{ $kecamatan->name }}</h1>
        <p class="text-gray-500 mt-2">Informasi, Layanan, dan Berita Terkini</p>
    </div>

    {{-- Grid untuk Populer & Berita Terkini --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        {{-- Kolom Populer --}}
        <div class="lg:col-span-1 anim-fade-in-left" style="--anim-delay: 400ms;">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 h-full">
                <h3 class="font-bold mb-4 text-gray-700">POPULER</h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start group">
                        <span class="bg-gray-800 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-md mr-3 mt-0.5 flex-shrink-0">1</span>
                        <a href="#" class="text-gray-800 font-medium group-hover:text-green-600 transition duration-300">Informasi Kependudukan Kecamatan {{ $kecamatan->name }}</a>
                    </li>
                    <li class="flex items-start group">
                        <span class="bg-gray-800 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-md mr-3 mt-0.5 flex-shrink-0">2</span>
                        <a href="#" class="text-gray-800 font-medium group-hover:text-green-600 transition duration-300">Jadwal Pelayanan Kantor Kecamatan Minggu Ini</a>
                    </li>
                    <li class="flex items-start group">
                        <span class="bg-gray-800 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-md mr-3 mt-0.5 flex-shrink-0">3</span>
                        <a href="#" class="text-gray-800 font-medium group-hover:text-green-600 transition duration-300">Sejarah dan Visi Misi Kecamatan {{ $kecamatan->name }}</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Kolom Berita Terkini --}}
        <div class="lg:col-span-2 anim-fade-in-right" style="--anim-delay: 550ms;">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 h-full group">
                <h3 class="font-bold mb-4 text-gray-700">BERITA TERKINI</h3>
                <a href="#" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-5">
                    <div class="w-full sm:w-1/3">
                        <img src="https://placehold.co/400x300/e2e8f0/64748b?text=Berita" alt="Berita" class="w-full h-auto object-cover rounded-md transform group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="w-full sm:w-2/3 text-sm">
                        <h4 class="font-bold text-lg mb-1 text-gray-800 group-hover:text-green-600 transition">Kunjungan Bupati Subang ke Kantor Kecamatan {{ $kecamatan->name }}</h4>
                        <p class="text-gray-600 leading-relaxed">Bupati Subang meninjau langsung progres pelayanan publik dan menyapa para aparatur sipil negara untuk memastikan semua layanan berjalan optimal bagi masyarakat...</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Grid untuk Kalender Acara --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        {{-- Kolom Kalender Acara --}}
        <div class="lg:col-span-2 bg-gray-50 border border-gray-200 rounded-lg p-5 group anim-fade-in-left" style="--anim-delay: 700ms;">
            <h3 class="font-bold mb-4 text-gray-700">KALENDER ACARA</h3>
            <a href="#" class="block">
                <div class="overflow-hidden rounded-md mb-4">
                    <img src="https://placehold.co/800x400/e2e8f0/64748b?text=Gambar+Acara" alt="Acara" class="w-full transform group-hover:scale-105 transition-transform duration-500 ease-in-out">
                </div>
                <h4 class="font-bold text-lg text-gray-800 group-hover:text-green-600 transition">Subang Fun Run 2025 di Alun-Alun Kecamatan</h4>
                <p class="text-sm text-gray-600 mt-1">Kegiatan lari santai dalam rangka memeriahkan HUT Kabupaten Subang akan diselenggarakan di wilayah Kecamatan {{ $kecamatan->name }}.</p>
            </a>
        </div>
        
        {{-- Kolom Widget Kalender & Agenda --}}
        <div class="lg:col-span-1 bg-cyan-50 border border-cyan-200 rounded-lg p-5 flex flex-col anim-fade-in-right" style="--anim-delay: 850ms;">
            <div class="bg-white rounded-lg shadow-md p-4 transition-shadow duration-300 hover:shadow-xl">
                <div class="flex justify-between items-center mb-3">
                    <button id="prev-month-btn" class="p-2 rounded-full hover:bg-gray-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                    <h4 id="month-year-title" class="font-bold text-gray-800 text-lg"></h4>
                    <button id="next-month-btn" class="p-2 rounded-full hover:bg-gray-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                </div>
                <hr>
                <div class="grid grid-cols-7 text-center text-xs font-semibold text-gray-400 mt-3 mb-2">
                    <div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div><div>Su</div>
                </div>
                <div id="calendar-dates" class="grid grid-cols-7 text-center text-sm -mx-1">
                    {{-- Tanggal akan di-generate oleh JavaScript --}}
                </div>
            </div>
            
            <div id="agenda-list" class="mt-5 space-y-4 flex-grow overflow-y-auto pr-2" style="max-height: 200px;">
                {{-- Agenda akan di-generate oleh JavaScript --}}
            </div>
        </div>
    </div>

    {{-- ====================================================================== --}}
    {{-- =                 BAGIAN LAYANAN (DIMASUKKAN KEMBALI)                = --}}
    {{-- ====================================================================== --}}
    <div class="mb-10 anim-fade-in-up" style="--anim-delay: 1000ms;">
        <h3 class="font-bold text-xl text-center mb-6 text-gray-700">LAYANAN</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-6 text-center">
            {{-- Loop untuk 7 ikon layanan sesuai gambar --}}
            @for ($i = 0; $i < 7; $i++)
            <a href="#" class="block group anim-scale-in" style="--anim-delay: {{ 1100 + ($i * 100) }}ms;">
                <div class="bg-gray-100 rounded-full w-20 h-20 mx-auto flex items-center justify-center border-2 border-gray-200 group-hover:border-green-400 group-hover:bg-white transition duration-300 transform group-hover:-translate-y-1">
                    <svg class="w-10 h-10 text-gray-400 group-hover:text-green-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="mt-3 text-sm font-semibold text-gray-700 group-hover:text-green-600 transition">Layanan {{$i + 1}}</p>
            </a>
            @endfor
        </div>
    </div>
    
    {{-- Placeholder untuk bagian Berita dan Galeri --}}
    <div class="space-y-8 mt-12">
        <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-400 h-64 flex items-center justify-center border-t-4 border-green-500 anim-fade-in-up" style="--anim-delay: 1400ms;">BERITA</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6 text-center text-gray-400 h-64 flex items-center justify-center border-t-4 border-green-500 anim-fade-in-left" style="--anim-delay: 1500ms;">GALERI VIDEO</div>
            <div class="md:col-span-1 bg-white rounded-lg shadow-md p-6 text-center text-gray-400 h-64 flex items-center justify-center border-t-4 border-green-500 anim-fade-in-right" style="--anim-delay: 1600ms;">GALERI FOTO</div>
        </div>
    </div>

</div>

{{-- Menambahkan script di akhir section untuk interaktivitas kalender dan agenda --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const monthYearTitle = document.getElementById('month-year-title');
    const calendarDatesContainer = document.getElementById('calendar-dates');
    const prevMonthBtn = document.getElementById('prev-month-btn');
    const nextMonthBtn = document.getElementById('next-month-btn');
    const agendaListContainer = document.getElementById('agenda-list');

    let currentDate = new Date();
    currentDate.setDate(1);

    // Menggunakan tanggal saat ini (Juli 2025) untuk dummy data
    const currentYear = 2025;
    const currentMonth = 6; // 0-based index untuk Juli adalah 6
    const dummyAgenda = {
        '2025-07-16': [
            { time: '16 Jul', description: 'Menghadiri undangan dari PT Meiloon' },
            { time: '16 Jul - 17 Jul', description: 'Menghadiri undangan dari Yayasan Dana Sejahtera Mandiri (DAMANDIRI)' },
        ],
        '2025-08-01': [
            { time: '1 Aug', description: 'Menghadiri undangan dari PERPAMSI' }
        ]
    };

    function renderCalendar() {
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();
        monthYearTitle.textContent = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' }).format(currentDate);
        calendarDatesContainer.innerHTML = '';
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let dayOffset = (firstDayOfMonth === 0) ? 6 : firstDayOfMonth - 1;
        for (let i = 0; i < dayOffset; i++) {
            calendarDatesContainer.innerHTML += `<div class="p-2"></div>`;
        }
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const hasAgenda = dummyAgenda[dateStr];
            let dateButton = document.createElement('button');
            dateButton.className = 'p-2 m-0.5 rounded-full transition-all duration-200 calendar-date transform hover:scale-110';
            dateButton.textContent = day;
            dateButton.dataset.date = dateStr;
            if (hasAgenda) {
                dateButton.classList.add('font-bold', 'border', 'border-cyan-500');
            }
            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dateButton.classList.add('bg-cyan-500', 'text-white', 'active-date');
            } else {
                dateButton.classList.add('hover:bg-gray-200');
            }
            calendarDatesContainer.appendChild(dateButton);
        }
        addDateClickListeners();
        renderAgendaForMonth(year, month);
    }

    function renderAgendaForMonth(year, month) {
        agendaListContainer.innerHTML = '';
        let hasAgendaThisMonth = false;
        Object.keys(dummyAgenda).forEach(dateStr => {
            const agendaDate = new Date(dateStr);
            if (agendaDate.getFullYear() === year && agendaDate.getMonth() === month) {
                hasAgendaThisMonth = true;
                dummyAgenda[dateStr].forEach(agenda => {
                    let agendaItem = `<div class="flex items-start py-2 anim-fade-in-up" style="--anim-delay: 100ms;"><div class="w-24 text-center font-bold text-sm border-r-2 border-gray-300 pr-4 flex-shrink-0">${agenda.time}</div><div class="pl-4 text-sm text-gray-700">${agenda.description}</div></div>`;
                    agendaListContainer.innerHTML += agendaItem;
                });
            }
        });
        if (!hasAgendaThisMonth) {
            agendaListContainer.innerHTML = '<p class="text-sm text-center text-gray-500 py-4 anim-fade-in-up">Tidak ada agenda di bulan ini.</p>';
        }
    }

    function addDateClickListeners() {
        document.querySelectorAll('.calendar-date').forEach(button => {
            button.addEventListener('click', function () {
                const currentActive = document.querySelector('.active-date');
                if (currentActive) {
                    currentActive.classList.remove('active-date', 'bg-cyan-500', 'text-white');
                    currentActive.classList.add('hover:bg-gray-200');
                }
                this.classList.add('active-date', 'bg-cyan-500', 'text-white');
                this.classList.remove('hover:bg-gray-200');
            });
        });
    }

    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Set kalender ke tanggal saat ini (Juli 2025) saat pertama kali load
    currentDate = new Date(currentYear, currentMonth, 1);
    renderCalendar();
});
</script>
@endpush

@endsection
