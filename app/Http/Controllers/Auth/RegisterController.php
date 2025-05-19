<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ], [
            'email.unique' => 'Bu eposta adresi kullanılıyor.',
            'email.required' => 'Eposta alanı zorunludur.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
            'password.min' => 'Şifre en az 6 karakter olmalı.',
            'name.required' => 'İsim alanı zorunludur.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}
