<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\Duyurular;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

// Anasayfa (/ ve /anasayfa aynı view'a gider)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/anasayfa', [HomeController::class, 'index'])->name('anasayfa');

// Giriş / Kayıt işlemleri
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Kullanıcı Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Etkinlik Arama
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');

// Etkinlik Oluşturma
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');

// Sepet İşlemleri
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Ürünler Sayfası
Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

// Duyuru Gösterimi
Route::get('/duyuru/{id}', function ($id) {
    $duyuru = Duyurular::findOrFail($id);

    $viewed = Session::get('viewed_duyurular', []);

    if (!in_array($id, $viewed)) {
        $duyuru->increment('views');
        $viewed[] = $id;
        Session::put('viewed_duyurular', $viewed);
    }

    return view('duyurular.goster', compact('duyuru'));
});

// Post Detay Sayfası
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
