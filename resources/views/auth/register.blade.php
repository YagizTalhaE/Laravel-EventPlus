@extends('layouts.app')

@section('title', 'Kayıt Ol')

@section('content')
    <div class="auth-container">
        <div class="auth-box">

            {{-- Hata mesajları burada gösterilecek --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="background-color:#f8d7da; color:#842029; padding:12px 20px; margin-bottom:15px; border-radius:5px; border:1px solid #f5c2c7;">
                    <ul style="margin:0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2>Kayıt Ol</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label for="name">Ad Soyad</label>
                <input type="text" name="name" required placeholder="Adınızı girin" value="{{ old('name') }}">

                <label for="email">E-Posta</label>
                <input type="email" name="email" required placeholder="E-posta adresinizi girin" value="{{ old('email') }}">

                <label for="password">Şifre</label>
                <input type="password" name="password" required placeholder="Şifre oluşturun">

                <label for="password_confirmation">Şifre (Tekrar)</label>
                <input type="password" name="password_confirmation" required placeholder="Şifrenizi tekrar girin">

                <button type="submit" class="btn primary">Kayıt Ol</button>
            </form>
            <p class="auth-switch">Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a></p>
        </div>
    </div>
@endsection
