@extends('layouts.app')

@section('title', 'EventPlus - Etkinlik')

@section('content')

    @if(session('success'))
        <div id="success-alert" style="
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 15px;
        margin: 20px auto;
        border-radius: 5px;
        max-width: 600px;
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: relative;
    ">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 500);
                }
            }, 3000);
        </script>
    @endif

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
                    <div onclick="openModal({{ $duyuru->id }})" style="
                    background: white;
                    padding: 15px;
                    border-radius: 10px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                    margin-bottom: 15px;
                    transition: transform 0.2s ease;
                    cursor: pointer;
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


        <!-- ORTA: Etkinlik Detaylama -->
        <div class="container">
            <div class="event-detail" style="max-width: 800px; margin: auto; padding: 20px;">

                {{-- Ortalanmış Başlık ve Görsel --}}
                <div style="text-align: center; margin-bottom: 20px;">
                    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 20px;">{{ $etkinlik->baslik }}</h1>

                    <img src="{{ asset('storage/' . $etkinlik->gorsel) }}"
                         alt="{{ $etkinlik->baslik }}"
                         style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                </div>

                {{-- Diğer içerikler sola hizalı şekilde devam eder --}}
                <p><strong>Adres:</strong> {{ $etkinlik->adres }}, {{ $etkinlik->ilce }}</p>
                <p><strong>Mekan:</strong> {{ $etkinlik->mekan }}</p>
                <p><strong>Tarih:</strong>
                    {{ \Carbon\Carbon::parse($etkinlik->baslangic_tarihi)->translatedFormat('d F Y') }} -
                    {{ \Carbon\Carbon::parse($etkinlik->bitis_tarihi)->translatedFormat('d F Y') }}
                </p>

                <p><strong>Saat:</strong>
                    {{ \Carbon\Carbon::parse($etkinlik->baslangic_tarihi)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($etkinlik->bitis_tarihi)->format('H:i') }}
                </p>
                <p><strong>Kontenjan:</strong> {{ $etkinlik->kontenjan }} kişi</p>
                <p><strong>Bilet Fiyatı:</strong> ₺{{ number_format($etkinlik->bilet_fiyati, 2) }}</p>

                <hr style="margin: 20px 0;">

                <h3 style="font-size: 1.2rem; font-weight: bold;">Etkinlik Detayları</h3>
                <p>{!! nl2br(e($etkinlik->aciklama)) !!}</p>

                <h3 style="font-size: 1.2rem; font-weight: bold; margin-top: 20px;">Kurallar</h3>
                <p>{!! nl2br(e($etkinlik->kurallar)) !!}</p>

                <hr style="margin: 20px 0;">

                @if(session('success'))
                    <div style="color: green; font-weight: bold; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('sepete.ekle') }}" style="margin-top: 20px;">
                    @csrf
                    <input type="hidden" name="etkinlik_id" value="{{ $etkinlik->id }}">

                    <label for="adet" style="font-weight: bold;">Bilet Adedi:</label>
                    <input
                        type="number"
                        id="adet"
                        name="adet"
                        value="1"
                        min="1"
                        max="{{ $etkinlik->kontenjan }}"
                        style="width: 80px; padding: 5px; margin-left: 10px; margin-bottom: 10px;">

                    <button
                        type="submit"
                        style="display: inline-block; background-color: #ff6600; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        Sepete Ekle
                    </button>
                </form>

            </div>
        </div>

        <!-- SAĞ: Önerilen Etkinlikler -->
        <div style="flex: 1;">
            <section style="background: #f9f9f9; padding: 20px; border-radius: 12px;">
                <h3 style="margin-bottom: 15px;">🎯 Önerilen Etkinlikler</h3>

                @auth
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
                            </div>
                        @endforeach
                    @else
                        <p>Henüz ilgi alanlarına göre öneri yok.</p>
                    @endif
                @else
                    <p>Önerilen etkinlikleri görüntülemek için üyelik girişi yapınız.</p>
                @endauth
            </section>
        </div>

    </div>

    <!-- Modal HTML -->
    <div id="announcementModal" style="
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    animation: fadeInBg 0.3s ease forwards;
">
        <div id="modalContentBox" style="
        background: white;
        padding: 2rem;
        border-radius: 12px;
        max-width: 600px;
        width: 90%;
        position: relative;
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 0.4s ease, transform 0.4s ease;
    ">
        <span onclick="closeModal()" style="
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        ">&times;</span>
            <h3 id="modalTitle" style="margin-bottom: 1rem;"></h3>
            <p id="modalContent" style="margin-bottom: 1rem;"></p>
            <small id="modalDate" style="color: #888;"></small>
        </div>
    </div>

    <style>
        @keyframes fadeInBg {
            from { background-color: rgba(0,0,0,0); }
            to { background-color: rgba(0,0,0,0.6); }
        }
    </style>

    <script>
        const announcements = @json($duyurular);

        function openModal(id) {
            const duyuru = announcements.find(item => item.id === id);
            if (!duyuru) return;

            // İçeriği doldur
            document.getElementById('modalTitle').innerText = duyuru.baslik;
            document.getElementById('modalContent').innerText = duyuru.icerik;
            document.getElementById('modalDate').innerText = new Date(duyuru.created_at).toLocaleString('tr-TR');

            const modal = document.getElementById('announcementModal');
            const modalBox = document.getElementById('modalContentBox');

            modal.style.display = 'flex';

            // Fade-in başlat
            setTimeout(() => {
                modalBox.style.opacity = '1';
                modalBox.style.transform = 'scale(1)';
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('announcementModal');
            const modalBox = document.getElementById('modalContentBox');

            // Fade-out başlat
            modalBox.style.opacity = '0';
            modalBox.style.transform = 'scale(0.95)';

            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    </script>

@endsection

