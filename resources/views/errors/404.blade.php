<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Pemerintah Kabupaten Subang</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Menggunakan Poppins untuk kesan modern */
            background: linear-gradient(135deg, #e0f2f7 0%, #c1e4f4 100%); /* Latar belakang gradien lembut */
        }
        .card-animate {
            animation: fadeInScale 0.6s ease-out forwards;
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="relative w-full max-w-2xl bg-white p-8 md:p-12 rounded-3xl shadow-2xl text-center border border-gray-100 card-animate overflow-hidden">
        
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 opacity-40 rounded-3xl -z-10"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-48 h-48 bg-[#FCE405] rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 bg-[#1E4E7C] rounded-full opacity-10 blur-3xl"></div>
        
        <img src="{{ asset('img/logo.png') }}" 
             alt="Logo Pemerintah Kabupaten Subang" 
             class="mx-auto h-24 sm:h-28 mb-8 transition-transform transform hover:scale-105 duration-300 ease-in-out"
             onerror="this.onerror=null;this.src='https://placehold.co/96x96/e2e8f0/e2e8f0?text=Logo';">

        <h1 class="text-7xl sm:text-8xl md:text-9xl font-extrabold text-[#1E4E7C] tracking-tight mb-4 animate-pulse">
            404
        </h1>

        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 leading-tight">
            Oops! Halaman Tidak Dapat Ditemukan.
        </h2>

        <p class="text-gray-600 text-base sm:text-lg mb-8 max-w-md mx-auto">
            Kami mohon maaf, halaman yang Anda cari tidak ada. Mungkin tautan tersebut telah usang, dihapus, atau terjadi kesalahan pengetikan URL.
        </p>

        <a href="{{ url('/') }}" 
           class="inline-flex items-center justify-center px-8 py-3 bg-[#1E4E7C] hover:bg-blue-700 text-white font-semibold rounded-full shadow-lg 
                  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">
            <i class="fas fa-home mr-3 text-lg"></i>
            Kembali ke Beranda
        </a>

        <footer class="mt-12 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Pemerintah Kabupaten Subang. Hak Cipta Dilindungi.
        </footer>
    </div>

</body>
</html>