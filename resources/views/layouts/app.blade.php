<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'EventPlus')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('/logo.png') }}" alt="EventPlus Logo" class="logo-img" />
        EventPlus
    </div>

    <ul class="nav-links">
        <li class="dropdown">
            <a href="#" class="dropbtn">Etkinlikler</a>
            <ul class="dropdown-menu">
                <li><a href="#">Müzik</a></li>
                <li><a href="#">Sinema</a></li>
                <li><a href="#">Tiyatro</a></li>
                <li><a href="#">Spor</a></li>
                <li><a href="#">Eğitim</a></li>
                <li><a href="#">Atölye</a></li>
                <li><a href="#">Diğer</a></li>
            </ul>
        </li>
        <li><a href="{{ route('login') }}" class="btn login">Giriş Yap</a></li>
        <li><a href="{{ route('register') }}" class="btn signup">Kayıt Ol</a></li>
    </ul>
</nav>

<!-- Ana İçerik -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h4>Bilgiler</h4>
            <ul>
                <li><a href="#">İletişim</a></li>
                <li><a href="#">Sıkça Sorulan Sorular</a></li>
                <li><a href="#">Gizlilik Politikası</a></li>
                <li><a href="#">Kullanım Koşulları</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Hakkımda</h4>
            <p>EventPlus, TicketPass güvencesiyle şehrindeki en iyi etkinlikleri keşfetmeniz için kuruldu. Sizlere kaliteli ve güncel etkinlik bilgileri sunmayı amaçlıyoruz.</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 EventPlus. Tüm hakları saklıdır.</p>
    </div>
</footer>

</body>
</html>

