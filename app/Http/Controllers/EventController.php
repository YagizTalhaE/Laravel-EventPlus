<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtkinlikYönetimi;
use Illuminate\Support\Facades\Storage;
use App\Models\Duyurular;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EventController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $duyurular = Duyurular::latest()->take(5)->get(); // Örnek, anasayfadaki duyurular için

        // Arama varsa etkinlikleri isme göre filtrele
        $searchResults = EtkinlikYönetimi::where('baslik', 'like', "%{$query}%")->get();

        // Önerilen etkinlikler veya diğer veriler burada da gönderilebilir
        $recommendedPosts = auth()->check() ? $this->getRecommendedEvents() : collect();

        return view('anasayfa', [
            'duyurular' => $duyurular,
            'recommendedPosts' => $recommendedPosts,
            'populerEvents' => collect(), // boş bırakalım, çünkü arama yapıldı
            'searchResults' => $searchResults,
            'searchQuery' => $query,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'baslik' => 'required|string|max:255',
            'aciklama' => 'required|string',
            'baslangic_tarihi' => 'required|date',
            'bitis_tarihi' => 'required|date|after_or_equal:baslangic_tarihi',
            'adres' => 'required|string',
            'tur' => 'required|string',
            'gorsel' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Görseli kaydet
        if ($request->hasFile('gorsel')) {
            $imagePath = $request->file('gorsel')->store('public/gorseller');
            // Yalnızca dosya adını alalım
            $validated['gorsel'] = basename($imagePath);
        }

        EtkinlikYönetimi::create($validated);

        return redirect()->route('events.index')->with('success', 'Etkinlik başarıyla oluşturuldu!');
    }

    public function turBazliListele($tur)
    {
        $tur = ucfirst(strtolower($tur));

        $etkinlikler = EtkinlikYönetimi::where('tur', $tur)
            ->where('aktif', true)
            ->orderBy('baslangic_tarihi', 'asc')  // Tarihe göre sıralama burada
            ->get();

        $duyurular = Duyurular::latest()->take(5)->get();
        $recommendedPosts = auth()->check()
            ? EtkinlikYönetimi::inRandomOrder()->take(3)->get()
            : collect();

        return view('etkinlikler.tur', [
            'etkinlikler' => $etkinlikler,
            'tur' => $tur,
            'duyurular' => $duyurular,
            'recommendedPosts' => $recommendedPosts,
        ]);
    }

    public function tur($tur)
    {
        $etkinlikler = EtkinlikYönetimi::where('tur', $tur)->get();

        $duyurular = Duyurular::latest()->take(5)->get(); // burası önemli ✅

        $recommendedPosts = auth()->check()
            ? EtkinlikYönetimi::inRandomOrder()->take(3)->get()
            : collect();

        return view('tur', [
            'tur' => $tur,
            'etkinlikler' => $etkinlikler,
            'duyurular' => $duyurular,
            'recommendedPosts' => $recommendedPosts,
        ]);
    }
    public function detay($slug)
    {
        // Slug ile etkinliği bul (bulamazsa 404 döner)
        $event = EtkinlikYönetimi::where('slug', $slug)->firstOrFail();

        // Aktif ve son 5 duyuruyu çek
        $duyurular = Duyurular::where('aktif', 1)->latest()->take(5)->get();

        $user = auth()->user();

        $recommendedEvents = collect();

        if ($user) {
            // Kullanıcının tercih ettiği etkinlik türlerini al
            $userTurs = DB::table('user_etkinlik_tur')
                ->where('user_id', $user->id)
                ->pluck('tur')
                ->toArray();

            // Kullanıcının tercih ettiği türlerden, şu anki etkinlik dışındaki 4 rastgele etkinliği seç
            $recommendedEvents = EtkinlikYönetimi::whereIn('tur', $userTurs)
                ->where('aktif', true)
                ->where('id', '!=', $event->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }

        // View'a değişkenleri gönder
        return view('etkinlikler.detay', compact('event', 'recommendedEvents', 'duyurular'));
    }
}

