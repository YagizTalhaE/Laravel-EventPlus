<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $duyuru->baslik }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9fafb;
        padding: 2rem;
    }
    .container {
        max-width: 700px;
        margin: auto;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    h1 {
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    p {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    .footer {
        font-size: 0.9rem;
        color: #6b7280;
    }
</style>
</head>
<body>
<div class="container">
    <h1>{{ $duyuru->baslik }}</h1>
    <p>{{ $duyuru->icerik }}</p>
    <div class="footer">
        Görüntülenme Sayısı: {{ $duyuru->views }}
    </div>
</div>
</body>
</html>
