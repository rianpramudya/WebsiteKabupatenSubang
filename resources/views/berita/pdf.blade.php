<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $berita->judul }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background-color: #ffffff;
            color: #2d3748;
            line-height: 1.8;
            font-size: 14px;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            font-size: 28px;
            color: #1a202c;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .meta-info {
            font-size: 12px;
            color: #718096;
            margin-bottom: 24px;
            border-left: 4px solid #FCE405;
            padding-left: 12px;
        }
        .cover-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 24px;
        }
        .content { font-size: 14px; color: #2d3748; }
        .content img { max-width: 100%; height: auto; border-radius: 8px; margin: 16px 0; }
        .content p { margin-bottom: 1.2em; }
        hr { border: none; height: 1px; background-color: #e2e8f0; margin: 40px 0; }
    </style>
</head>
<body>
    <h1>{{ $berita->judul }}</h1>
    <div class="meta-info">
        Dipublikasikan pada {{ \Carbon\Carbon::parse($berita->published_at)->isoFormat('D MMMM YYYY') }}<br>
        Kategori: {{ $berita->kategori->nama ?? 'Tanpa Kategori' }}
    </div>
    @if($berita->gambar)
        <img src="{{ public_path('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="cover-image">
    @endif
    <div class="content">
        {!! $berita->isi !!}
    </div>
</body>
</html>