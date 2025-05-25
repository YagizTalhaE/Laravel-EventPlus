<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Duyurular;
use Illuminate\Support\Facades\DB;
use App\Models\EtkinlikYönetimi;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Popüler ve aktif etkinlikler
        $populerEvents = EtkinlikYönetimi::where('populer_mi', true)
            ->where('aktif', true)
            ->orderBy('baslangic_tarihi', 'asc')
            ->limit(4)
            ->get();

        // Duyurular
        $duyurular = Duyurular::where('aktif', true)
            ->latest()
            ->limit(5)
            ->get();

        // Kullanıcının seçtiği türler (user_etkinlik_tur tablosundan)
        $userTurs = [];
        if ($user) {
            $userTurs = \DB::table('user_etkinlik_tur')
                ->where('user_id', $user->id)
                ->pluck('tur')
                ->toArray();
        }

        // Bu türlerden rastgele 3 aktif etkinlik çekelim
        $recommendedEvents = collect();
        if (!empty($userTurs)) {
            $recommendedEvents = EtkinlikYönetimi::whereIn('tur', $userTurs)
                ->where('aktif', true)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }

        return view('anasayfa', [
            'duyurular' => $duyurular,
            'populerEvents' => $populerEvents,
            'recommendedEvents' => $recommendedEvents,
        ]);
    }

    public function arama(Request $request)
    {
        $query = $request->input('query');
        $searchQuery = $query;

        $searchResults = EtkinlikYönetimi::where('baslik', 'like', '%' . $query . '%')->get();

        $duyurular = Duyurular::where('aktif', true)
            ->latest()
            ->limit(5)
            ->get();

        // Kullanıcı giriş yapmışsa önerilen etkinlikler
        $recommendedEvents = collect();
        if (Auth::check()) {
            $user = Auth::user();
            $userTurler = $user->etkinlikTurleri()->pluck('tur')->toArray();

            $recommendedEvents = EtkinlikYönetimi::whereIn('tur', $userTurler)
                ->where('aktif', 1)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }

        return view('arama', compact('searchResults', 'searchQuery', 'duyurular', 'recommendedEvents'));
    }
}
