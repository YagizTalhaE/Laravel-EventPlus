@extends('layouts.app')

@section('title', 'EventPlus - Arama Sonuçları')

@section('content')
    <section class="search-results">
        <h1>Arama Sonuçları</h1>
        <p>Aradığınız: <strong>{{ $query }}</strong></p>

        <!-- Buraya gerçek arama sonuçlarını listele -->
    </section>
@endsection
