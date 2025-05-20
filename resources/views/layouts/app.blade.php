<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'EventPlus')</title>

    <!-- Özel stil dosyası -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Bootstrap 5 CSS ve Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #d40000;">
    <!-- Logo -->
    <div class="logo">
        <a href="{{ url('/') }}" style="color: white; font-weight: bold; font-size: 20px; text-decoration: none;">
            <img src="{{ asset('/logo.png') }}" alt="EventPlus Logo" style="height: 32px; vertical-align: middle;" />
            EventPlus
        </a>
    </div>

    <!-- Menü Alanı -->
    <div class="nav-right" style="display: flex; align-items: center; gap: 20px;">

        <!-- Etkinlikler Dropdown Menüsü -->
        <div class="dropdown">
            <a href="#" class="dropbtn" style="color: white; text-decoration: none;">Etkinlikler</a>
            <ul class="dropdown-menu">
                <li><a href="#">Müzik</a></li>
                <li><a href="#">Sinema</a></li>
                <li><a href="#">Tiyatro</a></li>
                <li><a href="#">Spor</a></li>
                <li><a href="#">Eğitim</a></li>
                <li><a href="#">Atölye</a></li>
                <li><a href="#">Diğer</a></li>
            </ul>
        </div>

        <!-- Sepetim (sadece giriş yapılmışsa görünür) -->
        @auth
            <a href="{{ route('cart.index') }}" style="color: white; text-decoration: none;">🛒 Sepetim</a>
        @endauth

        <!-- Kullanıcı Dropdown -->
        @auth
            <div class="dropdown">
                <a href="#" class="dropbtn" style="color: white; text-decoration: none; font-weight: bold;">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('profilim') }}">Profilim</a></li>
                    <li><a href="{{ route('sifre.degis') }}">Şifre Değiştir</a></li>
                    <li><a href="{{ route('hesap.ayar') }}">Hesap Ayarları</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="background: none; border: none;">Çıkış Yap</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <!-- Giriş yapmamış kullanıcılar için -->
            <a href="{{ route('login') }}" style="color: white; text-decoration: none;">Giriş Yap</a>
            <a href="{{ route('register') }}" style="color: white; text-decoration: none;">Kayıt Ol</a>
        @endauth
    </div>
</nav>

<!-- Ana İçerik Alanı -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <!-- Hakkımızda Alanı -->
        <div class="footer-section">
            <h4>Hakkımızda</h4>
            <p>{!! nl2br(e($ayarlar->hakkimda ?? 'Hakkımda bilgisi yok')) !!}</p>
        </div>

        <!-- Sosyal Medya Alanı -->
        <div class="footer-section">
            <h4>Sosyal Medya</h4>
            <p>Instagram: {{$ayarlar->instagram ?? 'Instagram bilgisi yok'}}</p>
            <p>Twitter: {{$ayarlar->twitter ?? 'Twitter bilgisi yok'}}</p>
            <p>Linkedin: {{$ayarlar->linkedin ?? 'Linkedin bilgisi yok'}}</p>
            <p>Facebook: {{$ayarlar->facebook ?? 'Facebook bilgisi yok'}}</p>
        </div>
        <!-- İletişim Bilgileri -->
        <div class="footer-section">
            <h4>İletişim</h4>
            <p>Adres: {{ $ayarlar->adres ?? 'Adres bilgisi yok' }}</p>
            <p>Telefon: {{ $ayarlar->telefon ?? 'Telefon bilgisi yok' }}</p>
            <p>Email: {{ $ayarlar->site_mail ?? 'Email bilgisi yok' }}</p>
        </div>

    </div>

    <!-- Alt Bilgi -->
    <div class="footer-bottom">
        <p>&copy; 2025 TicketPass - EventPlus. Tüm hakları saklıdır.</p>
    </div>
</footer>

<!-- Dropdown Menülerin Açılıp Kapanmasını Sağlayan JavaScript -->
<script>
    document.querySelectorAll('.dropdown').forEach(function (dropdown) {
        const button = dropdown.querySelector('.dropbtn');
        const menu = dropdown.querySelector('.dropdown-menu');

        // Menü tıklanınca aç/kapat
        button.addEventListener('click', function (e) {
            e.preventDefault();
            // Diğer menüleri kapat
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });
            // Mevcut menüyü toggle et
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        // Menü dışına tıklanırsa menüyü kapat
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
