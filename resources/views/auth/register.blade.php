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

                <div class="kvkk-container">
                    <input type="checkbox" id="kvkk" name="kvkk" {{ old('kvkk') ? 'checked' : '' }}>
                    <label for="kvkk" style="color: #007bff;" onclick="document.getElementById('kvkkModal').style.display='block'">
                        KVKK metnini okudum, kabul ediyorum.
                    </label>
                </div>

                <button type="submit" class="btn primary">Kayıt Ol</button>
            </form>

            <div id="kvkkModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:1000;">
                <div style="background:white; width:90%; max-width:600px; margin:80px auto; padding:30px; border-radius:10px; position:relative;">
                    <span onclick="document.getElementById('kvkkModal').style.display='none'" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer;">&times;</span>
                    <h2 style="margin-bottom: 15px;">Kişisel Verilerin Korunması Kanunu (KVKK)</h2>
                    <div style="max-height: 400px; overflow-y: auto; font-size: 14px; line-height: 1.6;">
                        {!! nl2br(e($kvkkMetni ?? 'KVKK metni yüklenemedi.')) !!}
                    </div>
                </div>
            </div>

            <p class="auth-switch">Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a></p>
        </div>
    </div>
@endsection
