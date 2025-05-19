<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // is_approved kontrolü
            if (! $user->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Hesabınız onaylanmamıştır.',
                ])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended('/anasayfa'); // Giriş sonrası yönlendirme
        }

        return back()->withErrors([
            'email' => 'E-Posta ve şifrenizi kontrol edin.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
