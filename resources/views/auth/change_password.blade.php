@extends('layouts.app')

@section('title', 'Şifreyi Güncelle')

@section('content')
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .update-password-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .update-password-box {
            background-color: #f4f4f4;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        .update-password-box h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #333;
        }

        .update-password-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .update-password-box input {
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .update-password-box button {
            width: 100%;
            padding: 12px;
            background-color: #d10000;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .update-password-box button:hover {
            background-color: #a80000;
        }

        .alert-box {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

    <div class="update-password-container">
        <div class="update-password-box">
            <h2>Şifrenizi Değiştirin</h2>

            @if ($errors->any())
                <div class="alert-box">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.change') }}">
                @csrf

                <label for="password">Yeni Şifre</label>
                <input type="password" name="password" id="password" required>

                <label for="password_confirmation">Yeni Şifre (Tekrar)</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>

                <button type="submit">Şifreyi Güncelle</button>
            </form>
        </div>
    </div>
@endsection
