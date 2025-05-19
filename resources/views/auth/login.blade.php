@if ($errors->any())
    <div id="alert-box" style="
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9999;
        max-width: 400px;
        text-align: center;
        font-weight: 600;
        ">
        <ul style="list-style: none; padding: 0; margin: 0 0 10px 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button onclick="document.getElementById('alert-box').style.display='none'" style="
            background: transparent;
            border: none;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            color: #842029;
            position: absolute;
            top: 10px;
            right: 15px;
            font-weight: bold;
        ">&times;</button>
    </div>
@endif

@extends('layouts.app')

@section('title', 'Giriş Yap')

@section('content')
    <div class="auth-container">
        <div class="auth-box">
            <h2>Giriş Yap</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">E-Posta</label>
                <input type="email" name="email" required placeholder="E-posta adresinizi girin">

                <label for="password">Şifre</label>
                <input type="password" name="password" required placeholder="Şifrenizi girin">

                <button type="submit" class="btn primary">Giriş Yap</button>
            </form>
            <p class="auth-switch">Hesabınız yok mu? <a href="{{ route('register') }}">Kayıt Ol</a></p>
        </div>
    </div>
@endsection

