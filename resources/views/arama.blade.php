@extends('layouts.app')

@section('title', 'EventPlus - Arama Sonuçları')

@section('content')

    <!-- Hero Alanı -->
    <section class="hero">
        <div class="hero-content">
            <h1>🔍 Arama Sonuçları</h1>
            <p>"{{ $searchQuery }}" için bulunan etkinlikler</p>
            <form class="search-form" method="GET" action="{{ route('events.search') }}">
                <input type="text" name="query" placeholder="Etkinlik ara..." value="{{ $searchQuery }}" />
                <button type="submit">Ara</button>
            </form>
        </div>
    </section>

    <div style="display: flex; gap: 20px; align-items: flex-start; margin-top: 40px;">

        <!-- SOL: Duyurular -->
        <div style="flex: 1;">
            <section style="background: #f9f9f9; padding: 20px; border-radius: 12px;">
                <h3 style="margin-bottom: 15px;">📢 Duyurular</h3>
                @forelse ($duyurular as $duyuru)
                    <div onclick="openModal({{ $duyuru->id }})" style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 15px; transition: transform 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <strong style="font-size: 16px;">{{ $duyuru->baslik }}</strong>
                        <p style="font-size: 14px; margin-top: 5px;">{{ Str::limit($duyuru->icerik, 80) }}</p>
                        <p style="font-size: 12px; color: #666; margin-top: 8px;">🕒 {{ \Carbon\Carbon::parse($duyuru->created_at)->format('d M Y H:i') }}</p>
                    </div>
                @empty
                    <p>Şu anda duyuru yok.</p>
                @endforelse
            </section>
        </div>

        <!-- ORTA: Arama Sonuçları -->
        <div style="flex: 2;">
            <section class="events">
                <h2>Arama Sonuçları</h2>
                <div class="event-grid">
                    @forelse ($searchResults as $etkinlik)
                        <div class="event-card">
                            <img src="{{ asset('storage/' . $etkinlik->gorsel) }}" alt="{{ $etkinlik->baslik }}" class="event-image">
                            <div class="event-details">
                                <a href="{{ route('etkinlik.detay', ['slug' => $etkinlik->slug]) }}" class="event-title-link">
                                    {{ $etkinlik->baslik }}
                                </a>
                                <div class="event-info"><strong>Şehir:</strong> {{ $etkinlik->adres }}</div>
                                <div class="event-info"><strong>Tarih:</strong> {{ \Carbon\Carbon::parse($etkinlik->baslangic_tarihi)->translatedFormat('d F Y') }}</div>
                                <div class="event-info"><strong>Saat:</strong> {{ \Carbon\Carbon::parse($etkinlik->baslangic_tarihi)->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <p>"{{ $searchQuery }}" için sonuç bulunamadı.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <!-- SAĞ: Önerilen Etkinlikler -->
        <div style="flex: 1;">
            <section style="background: #f9f9f9; padding: 20px; border-radius: 12px;">
                <h3 style="margin-bottom: 15px;">🎯 Önerilen Etkinlikler</h3>

                @auth
                    @if($recommendedEvents->count())
                        @foreach ($recommendedEvents as $event)
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
    <div id="announcementModal" style="display: none; position: fixed; z-index: 9999; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center;">
        <div id="modalContentBox" style="background: white; padding: 2rem; border-radius: 12px; max-width: 600px; width: 90%; position: relative; opacity: 0; transform: scale(0.95); transition: opacity 0.4s ease, transform 0.4s ease;">
            <span onclick="closeModal()" style="position: absolute; top: 10px; right: 15px; font-size: 1.5rem; cursor: pointer;">&times;</span>
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
            document.getElementById('modalTitle').innerText = duyuru.baslik;
            document.getElementById('modalContent').innerText = duyuru.icerik;
            document.getElementById('modalDate').innerText = new Date(duyuru.created_at).toLocaleString('tr-TR');
            const modal = document.getElementById('announcementModal');
            const modalBox = document.getElementById('modalContentBox');
            modal.style.display = 'flex';
            setTimeout(() => {
                modalBox.style.opacity = '1';
                modalBox.style.transform = 'scale(1)';
            }, 10);
        }
        function closeModal() {
            const modal = document.getElementById('announcementModal');
            const modalBox = document.getElementById('modalContentBox');
            modalBox.style.opacity = '0';
            modalBox.style.transform = 'scale(0.95)';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    </script>

@endsection
