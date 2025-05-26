<?php

// Bu dosya, kullanıcı giriş ve çıkış işlemlerini yöneten kontrolcüyü tanımlar.

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Laravel'in kimlik doğrulama (authentication) bileşenini içeri aktarır.

class LoginController extends Controller
{
    // Bu sınıf, kullanıcı giriş formunu gösterme, giriş işlemini gerçekleştirme ve çıkış yapma sorumluluğunu taşır.

    public function showLoginForm()
    {
        // Giriş formunu gösteren metot.
        return view('auth.login');
        // 'auth.login' görünümünü döndürür.
    }

    public function login(Request $request)
    {
        // Kullanıcı giriş işlemini gerçekleştiren metot.
        $credentials = $request->only('email', 'password');
        // İstekten sadece 'email' ve 'password' bilgilerini alır.

        if (Auth::attempt($credentials)) {
            // Kullanıcının kimlik bilgilerini doğrulamaya çalışır. Başarılı olursa true döner.
            $user = Auth::user();
            // Giriş yapan kullanıcı nesnesini alır.

            // Kullanıcı onaylı mı kontrol et
            if (! $user->is_approved) {
                // Eğer kullanıcı onaylı değilse.
                Auth::logout();
                // Kullanıcının oturumunu kapatır.
                return back()->withErrors([
                    'email' => 'Hesabınız onaylanmamıştır.',
                ])->withInput();
                // Giriş sayfasına hata mesajıyla geri yönlendirir ve girilen bilgileri korur.
            }

            // Şifre değişimi gerekiyor mu?
            if ($user->must_change_password) {
                // Eğer kullanıcının şifresini değiştirmesi gerekiyorsa.
                return redirect()->route('password.change.form');
                // Şifre değiştirme formuna yönlendirir.
            }

            // Başarılı giriş
            $request->session()->regenerate();
            // Oturum kimliğini yeniler (güvenlik için).
            return redirect()->intended('/anasayfa');
            // Kullanıcıyı önceden gitmek istediği sayfaya veya varsayılan olarak '/anasayfa'ya yönlendirir.
        }

        return back()->withErrors([
            'email' => 'E-Posta ve şifrenizi kontrol edin.',
        ])->withInput();
        // Giriş başarısız olursa, hata mesajıyla birlikte giriş sayfasına geri yönlendirir.
    }

    public function logout(Request $request)
    {
        // Kullanıcı çıkış işlemini gerçekleştiren metot.
        Auth::logout();
        // Kullanıcının oturumunu kapatır.
        $request->session()->invalidate();
        // Mevcut oturumu geçersiz kılar.
        $request->session()->regenerateToken();
        // CSRF token'ını yeniler.
        return redirect('/login');
        // Kullanıcıyı giriş sayfasına yönlendirir.
    }
}
