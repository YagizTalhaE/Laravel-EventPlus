@extends('layouts.app')

@section('title', 'Şifre Değiştir')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-warning text-dark text-center rounded-top-4">
                        <h4 class="mb-0">🔒 Şifre Değiştir</h4>
                    </div>

                    <div class="card-body bg-light p-4">

                        {{-- Başarı mesajı --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Hata mesajları --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profilim.sifre.guncelle') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label text-muted">Mevcut Şifre</label>
                                <input type="password" name="current_password" id="current_password" required
                                       class="form-control bg-white border-0 shadow-sm @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-muted">Yeni Şifre</label>
                                <input type="password" name="password" id="password" required
                                       class="form-control bg-white border-0 shadow-sm @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label text-muted">Yeni Şifre (Tekrar)</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="form-control bg-white border-0 shadow-sm">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-3">🔁 Şifreyi Güncelle</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
