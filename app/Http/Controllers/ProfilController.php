<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function profilim()
    {
        $user = auth()->user(); // Giriş yapan kullanıcı
        return view('profil.profilim', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->back()->with('success', 'Profil bilgileri güncellendi.');
    }

    public function showChangePasswordForm()
    {
        return view('profil.sifre');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'different:current_password'],
        ], [
            'current_password.required' => 'Mevcut şifre zorunludur.',
            'current_password.current_password' => 'Mevcut şifreniz hatalı.',
            'password.required' => 'Yeni şifre zorunludur.',
            'password.min' => 'Yeni şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Yeni şifre ve onayı eşleşmiyor.',
            'password.different' => 'Yeni şifre mevcut şifreden farklı olmalıdır.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Şifreniz başarıyla değiştirildi.');
    }

    public function hesapAyar()
    {
        $user = Auth::user();
        return view('profil.hesap-ayar', compact('user'));
    }

    public function hesapAyarGuncelle(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Bilgiler başarıyla güncellendi.');
    }

    public function hesapSil(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Hesabınız silindi.');
    }
}
