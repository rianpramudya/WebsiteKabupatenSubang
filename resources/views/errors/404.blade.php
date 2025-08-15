<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f8fafc; color: #636b6f; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { text-align: center; }
        .code { font-size: 5rem; font-weight: bold; }
        .message { font-size: 1.5rem; margin-top: 1rem; }
        a { color: #3490dc; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="code">404</div>
        <div class="message">Maaf, halaman yang Anda cari tidak dapat ditemukan.</div>
        <p><a href="{{ url('/') }}">Kembali ke Beranda</a></p>
    </div>
</body>
</html>