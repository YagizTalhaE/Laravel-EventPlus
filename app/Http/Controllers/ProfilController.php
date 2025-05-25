<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserEtkinlikTur;  // Modeli import et
use Illuminate\Support\Facades\DB;

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
        $user = auth()->user();

        // Kullanıcının seçtiği türler
        $selectedTurs = DB::table('user_etkinlik_tur')
            ->where('user_id', $user->id)
            ->pluck('tur')
            ->toArray();

        // Veritabanından benzersiz etkinlik türlerini çekiyoruz
        $allTurs = DB::table('etkinlik_yönetimis')
            ->select('tur')
            ->distinct()
            ->pluck('tur')
            ->toArray();

        return view('profil.hesap-ayar', compact('user', 'selectedTurs', 'allTurs'));
    }

    public function hesapAyarGuncelle(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'turs' => 'nullable|array',
            'turs.*' => 'string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Kullanıcının eski tercihlerini temizle
        $user->preferredTurs()->delete();

        // Yeni tercihleri ekle
        if ($request->turs) {
            foreach ($request->turs as $tur) {
                $user->preferredTurs()->create(['tur' => $tur]);
            }
        }

        return back()->with('success', 'Bilgiler ve önerilen türler başarıyla güncellendi.');
    }

    public function hesapSil(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Hesabınız silindi.');
    }

    public function turleriKaydet(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'tur' => 'array',
            'tur.*' => 'string',
        ]);

        // Eski kayıtları sil
        \DB::table('user_etkinlik_tur')->where('user_id', $user->id)->delete();

        // Yeni kayıtları ekle
        if ($request->has('tur')) {
            foreach ($request->tur as $tur) {
                \DB::table('user_etkinlik_tur')->insert([
                    'user_id' => $user->id,
                    'tur' => $tur,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Etkinlik türleri başarıyla kaydedildi.');
    }
}
