<?php

use Illuminate\Support\Facades\Route;
use App\Models\Duyurular;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('anasayfa');
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
