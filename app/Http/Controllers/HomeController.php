<?php

// Bu dosya, ana sayfa ve arama işlevlerini yöneten kontrolcüyü tanımlar.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Bu model bu kodda kullanılmıyor.
use App\Models\Duyurular;
use Illuminate\Support\Facades\DB; // Bu da kullanılmıyor, ancak DB::table yerine \DB::table kullanılmış.
use App\Models\EtkinlikYönetimi;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Bu sınıf, ana sayfa verilerini hazırlar ve arama sonuçlarını yönetir.

    public function index()
    {
        // Ana sayfa verilerini hazırlayan metot.
        $user = auth()->user();
        // Giriş yapmış kullanıcıyı alır.

        // Popüler ve aktif etkinlikler
        $populerEvents = EtkinlikYönetimi::where('populer_mi', true)
            ->where('aktif', true)
            ->orderBy('baslangic_tarihi', 'asc')
            ->limit(3)
            ->get();
        // Popüler ve aktif etkinlikleri başlangıç tarihine göre sıralayarak çeker.

        // Duyurular
        $duyurular = Duyurular::where('aktif', true)
            ->latest()
            ->limit(5)
            ->get();
        // Aktif duyuruları en yeniden eskiye doğru sıralayarak çeker.

        // Kullanıcının seçtiği türler (user_etkinlik_tur tablosundan)
        $userTurs = [];
        if ($user) {
            $userTurs = \DB::table('user_etkinlik_tur')
                ->where('user_id', $user->id)
                ->pluck('tur')
                ->toArray();
        }
        // Kullanıcı giriş yapmışsa, kullanıcının tercih ettiği etkinlik türlerini veritabanından çeker.

        // Bu türlerden rastgele 3 aktif etkinlik çekelim
        $recommendedEvents = collect();
        if (!empty($userTurs)) {
            $recommendedEvents = EtkinlikYönetimi::whereIn('tur', $userTurs)
                ->where('aktif', true)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }
        // Kullanıcının tercih ettiği türlere göre rastgele aktif etkinlikler önerir.

        return view('anasayfa', [
            'duyurular' => $duyurular,
            'populerEvents' => $populerEvents,
            'recommendedEvents' => $recommendedEvents,
        ]);
        // Ana sayfa görünümünü ilgili verilerle birlikte döndürür.
    }

    public function arama(Request $request)
    {
        // Arama işlevini gerçekleştiren metot.
        $query = $request->input('query');
        $searchQuery = $query;
        // Arama sorgusunu alır.

        $searchResults = EtkinlikYönetimi::where('baslik', 'like', '%' . $query . '%')->get();
        // Etkinlik başlıklarında arama yapar.

        $duyurular = Duyurular::where('aktif', true)
            ->latest()
            ->limit(5)
            ->get();
        // Aktif duyuruları çeker.

        // Kullanıcı giriş yapmışsa önerilen etkinlikler
        $recommendedEvents = collect();
        if (Auth::check()) {
            $user = Auth::user();
            // Kullanıcının etkinlik türü tercihlerini alır.
            $userTurler = $user->etkinlikTurleri()->pluck('tur')->toArray();

            $recommendedEvents = EtkinlikYönetimi::whereIn('tur', $userTurler)
                ->where('aktif', 1)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }
        // Kullanıcının tercih ettiği türlere göre rastgele etkinlikler önerir.

        return view('arama', compact('searchResults', 'searchQuery', 'duyurular', 'recommendedEvents'));
        // Arama sonuçları görünümünü ilgili verilerle birlikte döndürür.
    }
}
