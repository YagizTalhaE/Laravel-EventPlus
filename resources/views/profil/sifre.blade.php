@extends('layouts.app')

@section('title', 'Şifre Değiştir')

@section('content')
    <div class="container" style="max-width: 500px; margin: 40px auto;">
        <h2 style="margin-bottom: 20px;">🔒 Şifre Değiştir</h2>

        {{-- Başarı mesajı --}}
        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Hata mesajları --}}
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profilim.sifre.guncelle') }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label for="current_password">Mevcut Şifre</label>
                <input type="password" name="current_password" id="current_password" required style="width: 100%; padding: 8px;">
                @error('current_password')
                <div style="color: red; font-size: 14px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password">Yeni Şifre</label>
                <input type="password" name="password" id="password" required style="width: 100%; padding: 8px;">
                @error('password')
                <div style="color: red; font-size: 14px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password_confirmation">Yeni Şifren (Tekrar)</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required style="width: 100%; padding: 8px;">
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Şifreyi Güncelle</button>
        </form>
    </div>
@endsection
