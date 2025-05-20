<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        // Mevcut şifreyle aynı mı kontrol et
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Mevcut şifreyle aynı. Lütfen farklı bir şifre girin.',
            ]);
        }

        // Şifreyi güncelle
        $user->password = Hash::make($request->password);
        $user->must_change_password = false; // Şifre değişti, artık zorunlu değil
        $user->save();

        return redirect('/anasayfa')->with('success', 'Şifreniz başarıyla güncellendi.');
    }
}
