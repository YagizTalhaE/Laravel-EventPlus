@extends('layouts.app')

@section('title', 'EventPlus - Ana Sayfa')

@section('content')

    <!-- Hero Alanı -->
    <section class="hero">
        <div class="hero-content">
            <h1>Şehrindeki En İyi Etkinlikleri Keşfet</h1>
            <p>Konserler, tiyatrolar, atölyeler ve çok daha fazlası</p>
            <form class="search-form" method="GET" action="{{ route('events.search') }}">
                <input type="text" name="query" placeholder="Etkinlik ara..." />
                <button type="submit">Ara</button>
            </form>
        </div>
    </section>

    <!-- Popüler Etkinlikler -->
    <section class="events">
        <h2>Popüler Etkinlikler</h2>
        <div class="event-grid">
            <!-- Örnek Etkinlik Kartı -->
            <div class="event-card">
                <img src="{{ asset('images/yazkonser.png') }}" alt="Etkinlik 1" />
                <h3>Yaz Konseri 2025</h3>
                <p>İstanbul - 21 Haziran - Saat 18:00</p>
                <span class="price">₺650</span>
            </div>
            <div class="event-card">
                <img src="{{ asset('images/standupdogudemirkol.png') }}" alt="Etkinlik 2" />
                <h3>Stand-Up Gecesi - Doğu Demirkol</h3>
                <p>Ankara - 15 Temmuz - Saat 19:30</p>
                <span class="price">₺750</span>
            </div>
            <div class="event-card">
                <img src="{{ asset('images/hamlettiyatro.png') }}" alt="Etkinlik 3" />
                <h3>Hamlet Tiyatro Gösterisi</h3>
                <p>Erzurum - 27 Haziran - Saat 20:00</p>
                <span class="price">₺350</span>
            </div>
            <div class="event-card">
                <img src="{{ asset('images/samsunspor-sivasspor.png') }}" alt="Etkinlik 3" />
                <h3>Reeder Samsunspor - N.G.Sivasspor</h3>
                <p>Samsun - 18 Mayıs - Saat 19:00</p>
                <span class="price">₺550</span>
            </div>
            <!-- Daha fazla kart eklenebilir -->
        </div>
    </section>

@endsection
