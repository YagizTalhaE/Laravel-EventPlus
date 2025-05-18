
@extends('layouts.app') {{-- veya kendi layout'un varsa --}}
@section('content')
    <h1>Hoş Geldin, {{ auth()->user()->name }}</h1>
    <p>Burası kullanıcı anasayfası.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Çıkış Yap</button>
    </form>
@endsection

