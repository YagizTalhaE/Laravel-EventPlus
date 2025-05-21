<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtkinlikYönetimi;
use Illuminate\Support\Facades\Storage;
use App\Models\Duyurular;

class EventController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Burada event modelini kullanarak gerçek arama yapılabilir.
        // Şimdilik demo amaçlı sorguyu view'a gönderiyoruz.

        return view('events.search_results', compact('query'));
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

        $etkinlikler = EtkinlikYönetimi::where('tur', $tur)->paginate(9);
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
        $etkinlik = EtkinlikYönetimi::where('slug', $slug)->firstOrFail();
        $duyurular = Duyurular::latest()->take(5)->get();
        $recommendedPosts = auth()->check()
            ? EtkinlikYönetimi::inRandomOrder()->take(3)->get()
            : collect();

        return view('etkinlikler.detay', [
            'etkinlik' => $etkinlik,
            'duyurular' => $duyurular,
            'recommendedPosts' => $recommendedPosts,
        ]);
    }
}

