@extends('layouts.app')
{{-- Bu satır, sayfanın 'layouts.app' adlı ana düzen dosyasını kullandığını belirtir. --}}

@section('title', 'Profilim')
{{-- Bu satır, sayfanın başlığını 'Profilim' olarak ayarlar. --}}

@section('content')
    {{-- Bu kısım, ana düzendeki 'content' bölümüne eklenecek içeriği başlatır. --}}
    <div class="container mt-5">
        {{-- Bootstrap konteyneri, içeriği ortalar ve kenar boşlukları ekler. --}}
        <div class="row justify-content-center">
            {{-- İçeriği yatayda ortalamak için Bootstrap satır ve ortalama sınıfları kullanılır. --}}
            <div class="col-md-8">
                {{-- Orta boyutlu ekranlarda 8 sütun genişliğinde bir alan tanımlar. --}}

                <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; margin: 0 auto;">
                    {{-- Gölge, kenarlık ve yuvarlak köşelere sahip bir kart bileşeni oluşturur, genişliğini sınırlar ve ortalar. --}}
                    <div class="card-header bg-danger text-white text-center rounded-top-4">
                        {{-- Kart başlığı, kırmızı arka plan, beyaz metin, ortalanmış metin ve üstten yuvarlak köşelerle stilize edilmiştir. --}}
                        <h4 class="mb-0">👤 Profil Bilgilerim</h4>
                        {{-- Profil başlığı ve ikonu. --}}
                    </div>

                    <div class="card-body p-4 bg-light" style="max-width: 600px; margin: 0 auto;">
                        {{-- Kartın gövdesi, dolgu, açık renk arka plan, genişlik sınırı ve ortalama ile stilize edilmiştir. --}}

                        <div class="mb-3">
                            {{-- Alt boşluklu bir div oluşturur. --}}
                            <label class="form-label text-muted">Ad Soyad</label>
                            {{-- 'Ad Soyad' etiketi. --}}
                            <input type="text" class="form-control bg-white border-0 shadow-sm" value="{{ $user->name }}" readonly>
                            {{-- Kullanıcının adını gösteren, düzenlenemeyen bir metin girişi. --}}
                        </div>

                        <div class="mb-3">
                            {{-- Alt boşluklu bir div oluşturur. --}}
                            <label class="form-label text-muted">E-Posta</label>
                            {{-- 'E-Posta' etiketi. --}}
                            <input type="email"
                                   class="form-control bg-white border-0 shadow-sm"
                                   value="{{ $user->email }}"
                                   readonly
                                   style="width: 100%; font-size: 0.95rem; padding-right: 10px; white-space: normal; overflow-wrap: break-word;">
                            {{-- Kullanıcının e-posta adresini gösteren, düzenlenemeyen bir metin girişi, özel stil ile. --}}
                        </div>

                        <div class="mb-3">
                            {{-- Alt boşluklu bir div oluşturur. --}}
                            <label class="form-label text-muted">Hesap Oluşturulma Tarihi</label>
                            {{-- 'Hesap Oluşturulma Tarihi' etiketi. --}}
                            <input type="text" class="form-control bg-white border-0 shadow-sm"
                                   value="{{ $user->created_at->format('d.m.Y H:i') }}" readonly>
                            {{-- Kullanıcının hesap oluşturma tarihini biçimlendirilmiş olarak gösteren, düzenlenemeyen bir metin girişi. --}}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
{{-- 'content' bölümünün sonunu belirtir. --}}
