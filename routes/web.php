<?php

use Illuminate\Support\Facades\Route;
use App\Models\Duyurular;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;

Route::get('/anasayfa', function () {
    return view('anasayfa');  // resources/views/anasayfa.blade.php dosyasını gösterir
})->name('anasayfa');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/events/search', [EventController::class, 'search'])->name('events.search');

Route::get('/anasayfa', function () {
    return view('anasayfa');  // resources/views/anasayfa.blade.php dosyasını gösterir
})->name('anasayfa');

Route::get('/duyuru/{id}', function ($id) {
    $duyuru = Duyurular::findOrFail($id);

    // Session üzerinden kullanıcı bu duyuruyu daha önce gördü mü kontrol et
    $viewed = Session::get('viewed_duyurular', []);

    if (!in_array($id, $viewed)) {
        $duyuru->increment('views');

        // Bu duyuru ID'sini session'a ekle
        $viewed[] = $id;
        Session::put('viewed_duyurular', $viewed);
    }

    return view('duyurular.goster', compact('duyuru'));
});

