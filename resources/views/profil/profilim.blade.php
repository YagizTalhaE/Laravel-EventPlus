@extends('layouts.app')

@section('title', 'Profilim')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; margin: 0 auto;">
                    <div class="card-header bg-danger text-white text-center rounded-top-4">
                        <h4 class="mb-0">👤 Profil Bilgilerim</h4>
                    </div>

                    <div class="card-body p-4 bg-light" style="max-width: 600px; margin: 0 auto;">

                        <div class="mb-3">
                            <label class="form-label text-muted">Ad Soyad</label>
                            <input type="text" class="form-control bg-white border-0 shadow-sm" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">E-Posta</label>
                            <input type="email"
                                   class="form-control bg-white border-0 shadow-sm"
                                   value="{{ $user->email }}"
                                   readonly
                                   style="width: 100%; font-size: 0.95rem; padding-right: 10px; white-space: normal; overflow-wrap: break-word;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Hesap Oluşturulma Tarihi</label>
                            <input type="text" class="form-control bg-white border-0 shadow-sm"
                                   value="{{ $user->created_at->format('d.m.Y H:i') }}" readonly>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
