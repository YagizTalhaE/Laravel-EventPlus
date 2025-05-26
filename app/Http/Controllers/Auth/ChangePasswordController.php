<?php

// Bu dosya, kullanıcı şifre değiştirme işlemlerini yöneten kontrolcüyü tanımlar.

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    // Bu sınıf, şifre değiştirme formunu gösterme ve şifre güncelleme sorumluluğunu taşır.

    public function showChangeForm()
    {
        // Şifre değiştirme formunu gösteren metot.
        return view('auth.change_password');
    }

    public function updatePassword(Request $request)
    {
        // Kullanıcı şifresini güncelleyen metot.
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        // Gelen istek verilerini doğrular.

        $user = Auth::user();
        // Giriş yapmış kullanıcı nesnesini alır.

        // Mevcut şifreyle aynı mı kontrol et
        if (Hash::check($request->password, $user->password)) {
            // Yeni şifrenin mevcut şifreyle aynı olup olmadığını kontrol eder.
            return back()->withErrors([
                'password' => 'Mevcut şifreyle aynı. Lütfen farklı bir şifre girin.',
            ]);
            // Aynıysa hata mesajıyla geri yönlendirir.
        }

        // Şifreyi güncelle
        $user->password = Hash::make($request->password);
        // Yeni şifreyi hashleyerek kullanıcıya atar.
        $user->must_change_password = false; // Şifre değişti, artık zorunlu değil
        // Şifre değiştirme zorunluluğunu kaldırır.
        $user->save();
        // Kullanıcı bilgilerini veritabanına kaydeder.

        return redirect('/anasayfa')->with('success', 'Şifreniz başarıyla güncellendi.');
        // Kullanıcıyı ana sayfaya yönlendirir ve başarı mesajı gösterir.
    }
}
