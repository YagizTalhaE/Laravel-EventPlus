@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <section class="event-detail">
        <div class="event-header">
            <h1>{{ $post->title }}</h1>
            <p class="event-dates">
                {{ \Carbon\Carbon::parse($post->baslangic_tarihi)->format('d M Y H:i') }} -
                {{ \Carbon\Carbon::parse($post->bitis_tarihi)->format('d M Y H:i') }}
            </p>
        </div>

        @if ($post->gorsel)
            <div class="event-image">
                <img src="{{ asset('storage/' . $post->gorsel) }}" alt="{{ $post->title }}" />
            </div>
        @endif

        <div class="event-info">
            <p><strong>Şehir:</strong> {{ $post->adres }}</p>
            <p><strong>İlçe:</strong> {{ $post->ilce }}</p>
            <p><strong>Mekan:</strong> {{ $post->mekan }}</p>
        </div>

        <div class="event-description">
            <p>{{ $post->aciklama }}</p>
        </div>

        <a href="{{ url()->previous() }}" class="btn">← Geri Dön</a>
    </section>
@endsection
