@extends('layouts.app')

@section('title', 'Hesap Ayarları')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4">
                        <h4 class="mb-0">⚙️ Hesap Ayarları</h4>
                    </div>
                    <div class="card-body bg-light">

                        <form action="{{ route('hesap.ayar.guncelle') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Kullanıcı Adı</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-posta</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success">Güncelle</button>
                        </form>
                    </div>
                </div>


                    <!-- Önerilen Etkinlik Türleri -->
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-primary text-white text-center rounded-top-4">
                            <h4 class="mb-0">📋 Önerilen Etkinlik Türleri</h4>
                        </div>
                        <div class="card-body bg-light text-center">
                            <form action="{{ route('profil.turler.kaydet') }}" method="POST">
                                @csrf

                                <div class="row justify-content-center">
                                    @foreach($allTurs as $tur)
                                        <div class="col-6 col-md-4 mb-3 d-flex justify-content-center">
                                            <div class="form-check custom-check border rounded-3 shadow-sm p-3 w-100 text-start position-relative" style="max-width: 180px;">
                                                <input class="form-check-input position-absolute top-50 start-0 translate-middle-y ms-2"
                                                       type="checkbox"
                                                       name="tur[]"
                                                       value="{{ $tur }}"
                                                       id="tur_{{ $loop->index }}"
                                                       @if(in_array($tur, $selectedTurs)) checked @endif>
                                                <label class="form-check-label ms-4" for="tur_{{ $loop->index }}">
                                                    {{ ucfirst($tur) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">Kaydet</button>
                            </form>
                        </div>
                    </div>

                <!-- Hesabı Sil -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-danger text-white text-center rounded-top-4">
                        <h4 class="mb-0">🗑️ Hesabı Sil</h4>
                    </div>
                    <div class="card-body bg-light">
                        <p>Hesabınızı silerseniz bu işlem geri alınamaz. Emin misiniz?</p>
                        <form action="{{ route('hesap.sil') }}" method="POST" onsubmit="return confirm('Hesabınızı kalıcı olarak silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Hesabımı Kalıcı Olarak Sil</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

