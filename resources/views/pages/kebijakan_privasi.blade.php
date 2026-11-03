@extends('layouts.app')

@section('title', 'Kebijakan Privasi - Pemerintah Kabupaten Subang')

@push('styles')

<style>

    .hero-banner {
        width: 100%;
        background-image: url('https://hatirakyat.com/wp-content/uploads/2024/09/privacy-policy.jpg');
        background-size: cover;
        background-position: center;
        position: relative;

        padding-top: 8rem;
        padding-bottom: 18rem;

        min-height: 300px;
        color: #fff;
        background-color: #0d47a1;
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 51, 102, 0.7);
    }
    .hero-banner-content {
        position: relative;
        z-index: 10;
        text-align: center;
    }
    .hero-banner-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        padding: 0;
    }
    .hero-banner-content p {
        font-size: 1.125rem;
        margin-top: 0.5rem;
        opacity: 0.9;
    }

    .privacy-content h1, .privacy-content h2, .privacy-content h3 {
        text-align: left;
    }

    .privacy-content h1 {
        color: #1E4E7C;
        font-size: 2.25rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 0.5rem;
    }
    .privacy-content .subtitle {
        text-align: center;
        font-size: 1rem;
        margin-top: 0;
        margin-bottom: 2.5rem;
        color: #4B5563;
    }
    .privacy-content h2 {
        color: #1E4E7C;
        font-size: 1.75rem;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #E5E7EB;
    }
    .privacy-content p,
    .privacy-content li {
        text-align: justify;
        line-height: 1.75;
    }
    .privacy-content a {
        color: #1E4E7C;
        text-decoration: underline;
        font-weight: 500;
    }
    .privacy-content a:hover {
        color: #FF3B00;
    }
    .privacy-content ol {
        padding-left: 1.5rem;
    }
    .privacy-content ol[type="a"] {
        list-style-type: lower-alpha;
    }
    .privacy-content ol ol {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .container-wrapper {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .privacy-card {
            padding: 1rem;
            border-radius: 0.75rem;
        }
        .privacy-content h1 {
            font-size: 1.875rem;
        }
        .privacy-content h2 {
            font-size: 1.5rem;
        }
        .privacy-content .subtitle {
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')

<div class="hero-banner">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 hero-banner-content">

        <h1 class="text-white font-extrabold text-4xl sm:text-5xl md:text-6xl hidden">Kebijakan Privasi</h1>
        <p class="text-white text-md sm:text-lg mt-2 font-medium"></p>
    </div>
</div>

<div class="bg-gray-50 py-12 sm:py-16 container-wrapper">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-lg privacy-card">
            <div id="privacy-policy-content" class="privacy-content">

                <div class="text-center py-10">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4 mx-auto"></div>
                    <p class="text-gray-500">Memuat konten...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const privacyPolicyData = {
        title: "KEBIJAKAN PRIVASI",
        intro: [
            "Selamat datang di website resmi Pemerintah Daerah Kabupaten Subang (<a href='https://subang.go.id' target='_blank' rel='noopener noreferrer'>https://subang.go.id</a>). Kebijakan Privasi berikut ini menjelaskan bagaimana kami, Pemerintah Daerah Kabupaten Subang (“Kami”) mengumpulkan, menyimpan, menggunakan, mengolah, menguasai, mentransfer, mengungkapkan dan/atau melindungi Informasi Pribadi Anda. Kebijakan Privasi ini berlaku bagi seluruh pengguna Website, situs web dan/atau situs-situs turunannya yang Kami kelola, konten yang disediakan oleh Kami, selanjutnya secara bersama-sama disebut sebagai (“Website”), serta penggunaan layanan yang tersedia pada Website (“Layanan”), kecuali diatur pada kebijakan privasi yang terpisah.",
            "Mohon untuk membaca Kebijakan Privasi ini dengan seksama untuk memastikan bahwa Anda memahami bagaimana proses pengolahan data kami."
        ],
        tableOfContents: [
            "1.  Informasi Pribadi Yang Kami Kumpulkan.",
            "2.  Informasi Yang Kami Kumpulkan Dari Anda dan/atau Perangkat Seluler Anda Secara Langsung.",
            "3.  Informasi Yang Dikumpulkan Setiap Kali Anda Menggunakan Website dan/atau Mengunjungi Situs Web Kami.",
            "4.  Informasi Yang Dikumpulkan Dari Pihak Ketiga.",
            "5.  Informasi Tentang Pihak Ketiga Yang Anda Berikan Kepada Kami.",
            "6.  Penggunaan Informasi Pribadi Yang Kami Kumpulkan.",
            "7.  Pemberian Informasi Pribadi Yang Kami Kumpulkan.",
            "10. Penyimpanan Informasi Pribadi.",
            "11. Akses dan Koreksi Informasi Pribadi.",
            "12. Tempat Kami Menyimpan Informasi Pribadi Anda.",
            "13. Keamanan Informasi Pribadi Anda.",
            "14. Perubahan Atas Kebijakan Privasi Ini.",
            "15. Pengakuan dan Persetujuan.",
            "16. Data Anonim.",
            "17. Platform Pihak Ketiga.",
            "18. Cara Menghubungi Kami."
        ],
        sections: [
            {
                title: "1. Informasi Pribadi Yang Kami Kumpulkan",
                content: [
                    "Kami mengumpulkan informasi yang mengidentifikasikan dan/atau dapat digunakan untuk mengidentifikasi, menghubungi, dan/atau menemukan orang dan/atau perangkat yang terkait dengan informasi tersebut (\"Informasi Pribadi\"). Informasi Pribadi termasuk, tetapi tidak terbatas pada, nama lengkap, tanggal lahir, jenis kelamin, alamat e-mail, identitas berupa nomor induk kependudukan dan/atau nomor induk pegawai (apabila Anda merupakan pegawai negeri sipil). Kami dapat mengumpulkan informasi dalam berbagai macam bentuk dan tujuan (termasuk tujuan yang diizinkan berdasarkan peraturan perundang-undangan yang berlaku)."
                ]
            },
            {
                title: "2. Informasi Yang Kami Kumpulkan Dari Anda dan/atau Perangkat Seluler Anda Secara Langsung",
                content: [
                    "Ketika Anda mengakses informasi dan membutuhkan transaksi data dengan kami menggunakan Website, Anda harus memberikan kepada kami Informasi Pribadi tertentu, termasuk nama, nomor induk kependudukan, nomor telepon, dan alamat e-mail pribadi Anda yang sah."
                ]
            },
            {
                title: "3. Informasi Yang Dikumpulkan Setiap Kali Anda Menggunakan Website dan/atau Mengunjungi Situs Web Kami",
                content: [
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Setiap kali Anda menggunakan Website dan/atau mengunjungi situs web kami, kami dapat mengumpulkan data teknis tertentu sehubungan dengan penggunaan Anda seperti, alamat protokol internet, informasi halaman web yang sebelumnya atau selanjutnya dilihat, durasi setiap kunjungan/sesi, identitas perangkat internet atau alamat kontrol akses media, dan/atau informasi perangkat lainnya termasuk informasi mengenai produsen, model, dan/atau sistem operasi dari perangkat yang Anda gunakan untuk mengakses Website dan/atau situs web kami.",
                            "Ketika Anda menggunakan Website dan/atau mengunjungi situs web kami, informasi tertentu juga dapat dikumpulkan secara otomatis dengan menggunakan cookies. Cookies adalah berkas data kecil yang tersimpan pada komputer dan/atau perangkat seluler Anda. Kami menggunakan cookies untuk melacak aktivitas pengguna dengan tujuan untuk meningkatkan antarmuka dan/atau pengalaman pengguna. Sebagian besar perangkat seluler dan/atau peramban internet mendukung penggunaan cookies, namun Anda dapat menyesuaikan pengaturan pada perangkat seluler dan/atau peramban internet Anda untuk menolak beberapa jenis cookies dan/atau cookies spesifik tertentu. Perangkat seluler dan/atau peramban Anda juga memungkinkan Anda untuk menghapus cookies apapun yang sebelumnya telah tersimpan. Namun demikian, hal itu dapat mempengaruhi fungsi-fungsi yang tersedia pada Website atau situs web kami."
                        ]
                    }
                ]
            },
            {
                title: "4. Informasi Yang Dikumpulkan Dari Pihak Ketiga",
                content: [
                    "Kami juga dapat mengumpulkan Informasi Pribadi Anda dari pihak ketiga (termasuk Pemerintah dan/atau pihak lainnya yang memberikan layanan kepada kami, mengumpulkan Data Pribadi dan/atau melakukan tugas atas nama kami, dan/atau dengan siapa kami melakukan kerja sama). Dalam kasus tersebut, kami hanya akan mengumpulkan Informasi Pribadi Anda untuk dan/atau sehubungan dengan tujuan yang melibatkan pihak ketiga tersebut dan/atau tujuan kerja sama kami dengan pihak ketiga tersebut (tergantung pada situasinya)."
                ]
            },
            {
                title: "5. Informasi Tentang Pihak Ketiga Yang Anda Berikan Kepada Kami",
                content: [
                    "Anda dapat memberikan kepada kami Informasi Pribadi yang berkaitan dengan individu pihak ketiga lainnya (termasuk Informasi Pribadi yang berkaitan dengan pasangan Anda, anggota keluarga, teman, dan/atau individu lain). Anda tentu saja akan memerlukan persetujuan dari mereka terlebih dahulu untuk melakukannya - lihat “Pengakuan dan Persetujuan”, di bawah, untuk informasi lebih lanjut."
                ]
            },
            {
                title: "6. Penggunaan Informasi Pribadi Yang Kami Kumpulkan",
                content: [
                    "Kami dapat menggunakan Informasi Pribadi yang dikumpulkan untuk tujuan sebagai berikut maupun untuk tujuan lain yang diizinkan oleh peraturan perundang-undangan yang berlaku (\"Tujuan\") :",
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Kami dapat menggunakan Informasi Pribadi Anda:",
                            {
                                type: "ordered_list",
                                items: [
                                    "untuk mengidentifikasi dan mendaftarkan Anda sebagai pengguna dan untuk mengadministrasikan, memverifikasi, menonaktifkan, dan/atau mengelola akun Anda;",
                                    "untuk memfasilitasi atau memungkinkan verifikasi apapun yang menurut pertimbangan kami diperlukan sebelum memberikan layanan kepada Anda;",
                                    "untuk berkomunikasi dengan Anda dan/atau mengirimkan Anda informasi sehubungan dengan penggunaan Website;",
                                    "untuk memberitahu Anda mengenai segala pembaruan pada Website dan/atau perubahan pada layanan yang disediakan;",
                                    "untuk mengolah dan/atau menanggapi pertanyaan dan saran yang diterima dari Anda;",
                                    "untuk memelihara, mengembangkan, menguji, meningkatkan, dan/atau mempersonalisasikan Website dalam rangka memenuhi kebutuhan dan preferensi Anda sebagai pengguna; dan",
                                    "untuk memantau dan/atau menganalisis aktivitas, perilaku, dan/atau data demografis pengguna termasuk kebiasaan dan/atau penggunaan berbagai layanan yang tersedia di Website."
                                ]
                            }
                        ]
                    },
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Kami juga dapat menggunakan Informasi Pribadi Anda secara lebih umum untuk tujuan-tujuan sebagai berikut (walaupun dalam kasus tertentu kami akan bertindak secara wajar dan tidak menggunakan Informasi Pribadi Anda lebih dari apa yang diperlukan untuk tujuan tersebut):",
                            {
                                type: "ordered_list",
                                items: [
                                    "untuk melakukan proses dan/atau fungsi layanan terkait;",
                                    "untuk memantau penggunaan Website dan/atau mengelola, mendukung serta meningkatkan efisiensi kinerja, perkembangan, pengalaman pengguna dan/atau fungsi-fungsi Website;",
                                    "untuk memberikan bantuan sehubungan dengan dan/atau untuk menyelesaikan kesulitan teknis dan/atau masalah operasional dengan Website dan/atau layanan;",
                                    "untuk menghasilkan informasi statistik dan/atau data analitik untuk tujuan pengujian, penelitian, analisis, pengembangan layanan, dan/atau kerja sama;",
                                    "untuk mencegah, mendeteksi dan/atau menyelidiki segala kegiatan yang dilarang, ilegal, tidak sah, dan/atau curang; dan",
                                    "untuk memungkinkan kami mematuhi semua kewajiban berdasarkan peraturan perundang-undangan yang berlaku, termasuk namun tidak terbatas pada menanggapi permintaan, penyelidikan, dan/atau arahan peraturan, mematuhi persyaratan pengarsipan, pelaporan, dan/atau perizinan yang disyaratkan oleh peraturan yang berlaku) dan/atau melakukan pemeriksaan audit, uji tuntas dan penyelidikan."
                                ]
                            }
                        ]
                    }
                ]
            },
            {
                title: "7. Pemberian Informasi Pribadi Yang Kami Kumpulkan",
                content: [
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Kami dapat mengungkapkan atau membagikan Informasi Pribadi Anda dengan afiliasi dan pihak lain untuk tujuan sebagai berikut ini serta untuk tujuan lain yang diizinkan oleh peraturan perundang-undangan yang berlaku:",
                            {
                                type: "ordered_list",
                                items: [
                                    "jika disyaratkan atau diotorisasikan oleh peraturan perundang-undangan yang berlaku (termasuk namun tidak terbatas pada menanggapi pertanyaan terkait regulasi, penyelidikan atau pedoman, dan/atau mematuhi persyaratan atau ketentuan pengarsipan dan/atau pelaporan berdasarkan undang-undang), untuk tujuan yang ditentukan dalam peraturan perundang-undangan yang berlaku;",
                                    "jika diinstruksikan, diminta, disyaratkan dan/atau diperbolehkan oleh Pemerintah yang berwenang, untuk tujuan sebagaimana disebutkan dalam kebijakan Pemerintah, peraturan dan/atau peraturan perundang-undangan yang berlaku.",
                                    "jika terdapat proses hukum dalam bentuk apapun antara Anda dengan kami, atau antara Anda dengan pihak lain, sehubungan dengan dan/atau terkait dengan layanan, untuk keperluan proses hukum tersebut;",
                                    "sehubungan dengan segala proses verifikasi kami dan/atau pihak ketiga perlukan, sebelum memberikan layanan kepada Anda dan/atau kami mendaftarkan Anda sebagai pengguna;",
                                    "dalam keadaan darurat terkait keselamatan Anda, untuk keperluan menangani keadaan darurat tersebut; dan",
                                    "dalam situasi terkait kesehatan Anda atau kepentingan umum, kami dapat membagikan Informasi Pribadi Anda kepada Pemerintah yang berwenang dan/atau institusi lainnya yang dapat ditunjuk oleh Pemerintah yang berwenang dan/atau yang memiliki kerja sama dengan kami, untuk tujuan pelacakan kontak, mendukung inisiatif, kebijakan atau program Pemerintah, kesehatan publik dan/atau tujuan lainnya sebagaimana dibutuhkan secara wajar."
                                ]
                            }
                        ]
                    },
                    "Ketika Informasi Pribadi tidak perlu dikaitkan dengan Anda, kami akan melakukan upaya yang wajar untuk menghapus dikaitkannya Informasi Pribadi tersebut dengan Anda sebagai individu sebelum mengungkapkan dan/atau berbagi informasi tersebut.",
                    "Kami tidak akan menjual atau menyewakan Informasi Pribadi Anda.",
                    "Selain sebagaimana diatur dalam Kebijakan Privasi ini, kami dapat mengungkapkan dan/atau membagikan Informasi Pribadi Anda jika kami memberitahu Anda dan/atau kami telah memperoleh persetujuan Anda untuk pengungkapan atau pembagian tersebut."
                ]
            },
            {
                title: "8. Penyimpanan Informasi Pribadi",
                content: [
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Informasi Pribadi Anda hanya akan disimpan selama diperlukan untuk memenuhi tujuan dari pengumpulannya, dan/atau selama penyimpanan tersebut diperlukan dan/atau diperbolehkan oleh peraturan perundang-undangan yang berlaku. Kami akan berhenti menyimpan Informasi Pribadi dan/atau menghapus maksud dari dikaitkannya Informasi Pribadi tersebut dengan Anda sebagai individu, segera setelah dianggap bahwa tujuan pengumpulan Informasi Pribadi tersebut tidak lagi dibutuhkan dengan menyimpan Informasi Pribadi dan/atau penyimpanan tidak lagi diperlukan secara hukum.",
                            "Mohon diperhatikan bahwa masih ada kemungkinan bahwa beberapa Informasi Pribadi Anda disimpan oleh pihak lain termasuk institusi Pemerintah tertentu. Dalam hal kami membagikan Informasi Pribadi Anda kepada institusi Pemerintah yang berwenang dan/atau institusi lainnya yang dapat ditunjuk oleh Pemerintah yang berwenang atau memiliki kerja sama dengan kami, Anda menyetujui dan/atau mengakui bahwa penyimpanan Informasi Pribadi Anda oleh institusi terkait akan mengikuti kebijakan penyimpanan data masing-masing institusi tersebut. Informasi yang disampaikan melalui komunikasi antara pengguna dengan Pemerintah yang berwenang dan/atau institusi lainnya yang dapat ditunjuk oleh Pemerintah yang berwenang dan/atau yang memiliki kerja sama dengan kami, yang dilakukan selain melalui penggunaan Website juga dapat disimpan dengan beberapa cara. Kami tidak mengizinkan penyimpanan Informasi Pribadi dengan cara demikian dan kami tidak bertanggung jawab kepada Anda untuk hal tersebut. Kami tidak akan bertanggung jawab atas penyimpanan Informasi Pribadi Anda. Anda setuju untuk membebaskan kami dari dari tanggung jawab untuk setiap penyimpanan yang tidak sah atas Informasi Pribadi Anda."
                        ]
                    }
                ]
            },
            {
                title: "9. Akses dan Koreksi Informasi Pribadi",
                content: [
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Tunduk pada peraturan perundang-undangan yang berlaku, Anda dapat meminta kepada kami untuk mengakses dan/atau mengoreksi Informasi Pribadi Anda yang berada dalam kepemilikan dan penguasaan kami, dengan menghubungi kami di perincian yang disediakan di bawah ini.",
                            "Kami berhak menolak permintaan Anda untuk mengakses, atau untuk memperbaiki, sebagian atau semua Informasi Pribadi Anda yang kami miliki atau kuasai jika diizinkan dan/atau diperlukan berdasarkan perundang-undangan yang berlaku. Hal ini termasuk dalam keadaan dimana Informasi Pribadi tersebut dapat berisi referensi kepada orang lain atau dimana permintaan untuk akses dan/atau permintaan untuk mengoreksi adalah untuk alasan yang kami anggap tidak relevan, tidak serius, dan/atau menyulitkan."
                        ]
                    }
                ]
            },
            {
                title: "10. Tempat Kami Menyimpan Informasi Pribadi Anda",
                content: [
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Saat Anda menggunakan Website dan layanan kami di negara lain dimana Website kami dapat diakses (“Negara Tujuan”), kami dapat mentransfer Informasi Pribadi Anda dari negara asal (“Negara Asal”) ke Negara Tujuan untuk membuat Anda dapat mengakses dan memastikan pengalaman pelanggan yang lancar ketika Anda menggunakan Website kami di Negara Tujuan. Dalam hal tersebut, kami akan meminta persetujuan Anda untuk mentransfer Data Pribadi Anda dari Negara Asal ke Negara Tujuan untuk memastikan kepatuhan atas hukum dan peraturan yang berlaku.",
                            "Kami akan mematuhi seluruh peraturan dan/atau hukum yang berlaku dan/atau menggunakan seluruh usaha yang terbaik untuk memastikan pemberian tingkat perlindungan yang setara dengan komitmen kami dalam Kebijakan Privasi ini."
                        ]
                    }
                ]
            },
            {
                title: "11. Keamanan Informasi Pribadi Anda",
                content: [
                    "Kerahasiaan Informasi Pribadi Anda adalah hal yang terpenting bagi kami. Kami akan memberlakukan upaya terbaik untuk melindungi dan mengamankan data dan/atau Informasi Pribadi Anda dari akses, pengumpulan, penggunaan dan/atau pengungkapan oleh orang dan/atau dari pengolahan yang bertentangan dengan hukum, kehilangan yang tidak disengaja, pemusnahan dan kerusakan atau risiko serupa. Namun, pengiriman informasi melalui internet tidak sepenuhnya aman. Walaupun kami akan berusaha sebaik mungkin untuk melindungi Informasi Pribadi Anda, Anda mengakui bahwa kami tidak dapat menjamin keutuhan dan keakuratan Informasi Pribadi apa pun yang Anda kirimkan melalui Internet dan/atau menjamin bahwa Informasi Pribadi tersebut tidak akan dicegat, diakses, diungkapkan, diubah dan/atau dihancurkan oleh pihak ketiga yang tidak berwenang, karena faktor-faktor diluar kendali kami. Anda bertanggung jawab untuk menjaga kerahasiaan detail Akun Anda, termasuk kata sandi Anda dengan siapapun dan harus selalu menjaga dan/atau bertanggung jawab atas keamanan perangkat yang Anda gunakan."
                ]
            },
            {
                title: "12. Perubahan atas Kebijakan Privasi",
                content: [
                    "Kami dapat meninjau dan mengubah Kebijakan Privasi ini atas kebijakan kami sendiri dari waktu ke waktu, untuk memastikan bahwa Kebijakan Privasi ini konsisten dengan perkembangan kami di masa depan, dan/atau perubahan persyaratan hukum atau peraturan. Jika kami memutuskan untuk mengubah Kebijakan Privasi ini, kami akan memberitahu Anda tentang perubahan tersebut melalui pemberitahuan umum yang dipublikasikan pada Website dan/atau situs web, atau sebaliknya ke alamat e-mail Anda yang tercantum dalam Akun Anda. Anda setuju bahwa Anda bertanggung jawab untuk meninjau Kebijakan Privasi ini secara teratur untuk informasi terbaru tentang pengolahan data dan/atau praktik perlindungan data kami, dan bahwa dengan Anda terus menggunakan Website atau situs web kami, berkomunikasi dengan kami, dan/atau mengakses dan menggunakan layanan setelah adanya perubahan apapun terhadap Kebijakan Privasi ini akan dianggap sebagai persetujuan Anda terhadap Kebijakan Privasi ini dan/atau segala perubahannya."
                ]
            },
            {
                title: "13. Pengakuan dan Persetujuan",
                content: [
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Dengan menyetujui Kebijakan Privasi, Anda mengakui bahwa Anda telah membaca dan/atau memahami Kebijakan Privasi ini dan/atau menyetujui segala ketentuannya. Secara khusus, Anda setuju dan/atau memberikan persetujuan kepada kami untuk mengumpulkan, menggunakan, membagikan, mengungkapkan, menyimpan, mentransfer, dan/atau mengolah Informasi Pribadi Anda sesuai dengan Kebijakan Privasi ini.",
                            "Dalam keadaan dimana Anda memberikan kepada kami Informasi Pribadi yang berkaitan dengan individu lain (seperti Informasi Pribadi yang berkaitan dengan pasangan Anda, anggota keluarga, teman, dan/atau pihak lain), Anda menyatakan dan/atau menjamin bahwa Anda telah memperoleh persetujuan dari individu tersebut untuk, dan dengan ini menyetujui atas nama individu tersebut untuk, pengumpulan, penggunaan, pengungkapan dan/atau pengolahan Informasi Pribadi mereka oleh kami.",
                            "Anda dapat menarik persetujuan Anda untuk setiap atau segala pengumpulan, penggunaan dan/atau pengungkapan Informasi Pribadi Anda kapan saja dengan memberikan kepada kami pemberitahuan yang wajar secara tertulis menggunakan rincian kontak yang disebutkan di bawah ini. Tergantung pada keadaan dan/atau sifat persetujuan yang Anda tarik, Anda harus memahami dan/atau mengakui bahwa setelah penarikan persetujuan tersebut, Anda mungkin tidak lagi dapat menggunakan Website dan/atau layanan. Penarikan persetujuan Anda dapat mengakibatkan penghentian Akun Anda."
                        ]
                    }
                ]
            },
            {
                title: "14. Data Anonim",
                content: [
                    "Kami dapat membuat, menggunakan, melisensikan dan/atau mengungkapkan Informasi Pribadi, yang tersedia, dengan catatan:",
                    {
                        type: "ordered_list_alpha",
                        items: [
                            "Bahwa semua hal yang dapat mengidentifikasi telah dihapus sehingga data, baik sendiri dan/atau dikombinasi dengan data lain yang tersedia, tidak dapat dihubungkan dengan dan/atau dikaitkan dengan dan/atau tidak dapat mengidentifikasi suatu individu; dan",
                            "Data serupa telah digabungkan sehingga data asli membentuk bagian dari kumpulan data yang lebih besar."
                        ]
                    }
                ]
            },
            {
                title: "15. Platform Pihak Ketiga",
                content: [
                    "Saat Anda menggunakan Website kami dan mengaktifkan fitur sidik jari (fingerprint) dan/atau pengenalan wajah (facial recognition) di perangkat seluler Anda untuk keperluan autentikasi, harap dicatat bahwa kami tidak menyimpan data biometrik tersebut. Kecuali diberitahukan lain kepada Anda, data tersebut tersimpan di perangkat seluler Anda dan/atau dapat disimpan oleh pihak ketiga, seperti pembuat perangkat Anda. Anda setuju dan mengakui bahwa kami tidak bertanggung jawab atas setiap akses tidak sah atau kerugian apapun atas data biometrik yang tersimpan di perangkat seluler Anda."
                ]
            },
            {
                title: "16. Cara Menghubungi Kami",
                content: [
                    "Jika Anda memiliki pertanyaan mengenai Kebijakan Privasi dan/atau keluhan lainnya silahkan menghubungi <a href='mailto:diskominfo@subang.go.id'>diskominfo@subang.go.id</a>. Semua korespondensi Anda akan dicatat, direkam, dan disimpan untuk arsip Kami."
                ]
            },
            {
                title: null,
                content: [
                    "Saya telah membaca dan mengerti seluruh Kebijakan Privasi ini beserta konsekuensinya dan dengan ini menerima setiap hak, kewajiban, dan ketentuan yang diatur di dalamnya."
                ]
            }
        ],
    };

    function renderPrivacyPolicy(data) {
        const container = document.getElementById('privacy-policy-content');
        container.innerHTML = ''; // Membersihkan konten yang ada

        if (data.title) {
            const h1 = document.createElement('h1');
            h1.textContent = data.title;
            container.appendChild(h1);
        }
        if (data.subtitle) {
            const p = document.createElement('p');
            p.className = 'subtitle';
            p.textContent = data.subtitle;
            container.appendChild(p);
        }

        if (data.intro && data.intro.length > 0) {
            data.intro.forEach(text => {
                const p = document.createElement('p');
                p.innerHTML = text; // Gunakan innerHTML untuk tautan
                container.appendChild(p);
            });
        }

        if (data.tableOfContents && data.tableOfContents.length > 0) {
            const tocTitle = document.createElement('h2');
            tocTitle.textContent = "Kebijakan Privasi ini mencakup hal-hal sebagai berikut:";
            container.appendChild(tocTitle);

            const tocList = document.createElement('ol');
            data.tableOfContents.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                tocList.appendChild(li);
            });
            container.appendChild(tocList);
        }

        if (data.sections && data.sections.length > 0) {
            data.sections.forEach(section => {
                if (section.title) {
                    const h2 = document.createElement('h2');
                    h2.textContent = section.title;
                    container.appendChild(h2);
                }

                if (section.content && section.content.length > 0) {
                    section.content.forEach(item => {
                        if (typeof item === 'string') {
                            const p = document.createElement('p');
                            p.innerHTML = item; // Gunakan innerHTML untuk tautan
                            container.appendChild(p);
                        } else if (item.type === 'ordered_list' || item.type === 'ordered_list_alpha') {
                            const list = document.createElement('ol');
                            if (item.type === 'ordered_list_alpha') {
                                list.setAttribute('type', 'a');
                            }
                            item.items.forEach(listItem => {
                                const li = document.createElement('li');
                                if (typeof listItem === 'string') {
                                    li.innerHTML = listItem;
                                } else if (listItem.type === 'ordered_list') {
                                    const nestedList = document.createElement('ol');
                                    listItem.items.forEach(nestedItem => {
                                        const nestedLi = document.createElement('li');
                                        nestedLi.innerHTML = nestedItem;
                                        nestedList.appendChild(nestedLi);
                                    });
                                    li.appendChild(nestedList);
                                }
                                list.appendChild(li);
                            });
                            container.appendChild(list);
                        }
                    });
                }
            });
        }
    }

    window.addEventListener('load', () => {

        renderPrivacyPolicy(privacyPolicyData);
    });
</script>
@endpush
