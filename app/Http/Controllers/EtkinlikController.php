<?php

namespace App\Http\Controllers;

use App\Models\EtkinlikYönetimi;
use Illuminate\Http\Request;
use App\Models\Duyurular;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEtkinlikTur;

class EtkinlikController extends Controller
{
    public function apiIndex()
    {
        $etkinlikler = EtkinlikYönetimi::where('aktif', 1)->get();

        return response()->json($etkinlikler);
    }

    public function populerEtkinlikler()
    {
        $etkinlikler = EtkinlikYönetimi::where('populer_mi', 1)
            ->where('aktif', 1)
            ->orderBy('baslangic_tarihi', 'asc')  // Tarihe göre azalan sıralama
            ->get();

        return response()->json($etkinlikler);
    }

    public function turEtkinlikleri($tur)
    {
        // Türe göre aktif etkinlikleri getir
        $etkinlikler = EtkinlikYönetimi::where('tur', $tur)
            ->where('aktif', 1)
            ->orderBy('baslangic_tarihi', 'asc')
            ->get();

        // Son 5 duyuruyu getir
        $duyurular = Duyurular::orderBy('created_at', 'desc')->limit(5)->get();

        $recommendedEvents = collect();

        if (Auth::check()) {
            $user = Auth::user();

            // Kullanıcının seçtiği türleri al, eğer hiç tür yoksa boş dizi olsun
            $userTurler = $user->etkinlikTurleri()->pluck('tur')->toArray();

            if (!empty($userTurler)) {
                // Kullanıcının ilgi alanlarına göre rastgele 3 öneri etkinlik getir
                $recommendedEvents = EtkinlikYönetimi::whereIn('tur', $userTurler)
                    ->where('aktif', 1)
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();
            }
        }

        return view('etkinlikler.tur', [
            'tur' => $tur,
            'etkinlikler' => $etkinlikler,
            'duyurular' => $duyurular,
            'recommendedEvents' => $recommendedEvents,
        ]);
    }

    public function tur($tur)
    {
        // Örnek: tür ismine göre etkinlikleri çek
        $etkinlikler = EtkinlikYönetimi::where('tur', $tur)->get();

        return view('etkinlikler.tur', compact('etkinlikler', 'tur'));
    }

}

