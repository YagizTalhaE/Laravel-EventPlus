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

    <!-- Ana İçerik Alanı -->
    <div style="display: flex; gap: 20px; align-items: flex-start; margin-top: 40px;">

        <!-- SOL: Duyurular -->
        <div style="flex: 1;">
            <section style="background: #f9f9f9; padding: 20px; border-radius: 12px;">
                <h3 style="margin-bottom: 15px;">📢 Duyurular</h3>
                @forelse ($duyurular as $duyuru)
                    <div style="
                        background: white;
                        padding: 15px;
                        border-radius: 10px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                        margin-bottom: 15px;
                        transition: transform 0.2s ease;
                    " onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <strong style="font-size: 16px;">{{ $duyuru->baslik }}</strong>
                        <p style="font-size: 14px; margin-top: 5px;">{{ Str::limit($duyuru->icerik, 80) }}</p>
                        <p style="font-size: 12px; color: #666; margin-top: 8px;">
                            🕒 {{ \Carbon\Carbon::parse($duyuru->created_at)->format('d M Y H:i') }}
                        </p>
                    </div>
                @empty
                    <p>Şu anda duyuru yok.</p>
                @endforelse
            </section>
        </div>

        <!-- ORTA: Popüler Etkinlikler -->
        <div style="flex: 2;">
            <section class="events">
                <h2>Popüler Etkinlikler</h2>
                <div class="event-grid">
                    <!-- Kartlar burada sabit olarak kaldı, istersen bunlar da veriyle dinamikleştirilebilir -->
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
                        <img src="{{ asset('images/samsunspor-sivasspor.png') }}" alt="Etkinlik 4" />
                        <h3>Reeder Samsunspor - N.G.Sivasspor</h3>
                        <p>Samsun - 18 Mayıs - Saat 19:00</p>
                        <span class="price">₺550</span>
                    </div>
                </div>
            </section>
        </div>

        <!-- SAĞ: Önerilen Etkinlikler -->
        <div style="flex: 1;">
            @auth
                <section style="background: #f9f9f9; padding: 20px; border-radius: 12px;">
                    <h3 style="margin-bottom: 15px;">🎯 Önerilen Etkinlikler</h3>
                    @if($recommendedPosts->count())
                        @foreach ($recommendedPosts as $event)
                            <div style="
                                background: white;
                                padding: 15px;
                                border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                                margin-bottom: 15px;
                                transition: transform 0.2s ease;
                            " onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                @if ($event->gorsel)
                                    <img src="{{ asset('storage/' . $event->gorsel) }}" alt="{{ $event->baslik }}" style="width: 100%; height: auto; object-fit: cover; border-radius: 8px;" />
                                @else
                                    <img src="{{ asset('images/default-event.jpg') }}" alt="{{ $event->baslik }}" style="width: 100%; height: auto; border-radius: 8px;" />
                                @endif

                                <h4 style="margin-top: 10px;">{{ $event->baslik }}</h4>
                                <p style="font-size: 14px;">{{ Str::limit($event->aciklama, 60) }}</p>
                                <p style="font-size: 12px; color: #555;">📍 {{ $event->adres }}</p>
                                <p style="font-size: 12px;">🕒 {{ \Carbon\Carbon::parse($event->baslangic_tarihi)->format('d M Y H:i') }}</p>
                                <a href="{{ route('etkinlik.detay', $event->id) }}" class="btn btn-sm">Detay</a>
                            </div>
                        @endforeach
                    @else
                        <p>Henüz ilgi alanlarına göre öneri yok.</p>
                    @endif
                </section>
            @endauth
        </div>

    </div>

@endsection
