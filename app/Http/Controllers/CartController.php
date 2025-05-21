<?php

namespace App\Http\Controllers;

use App\Models\EtkinlikYönetimi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Sepet sayfasını görüntüle
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Sepete etkinlik ekle
    public function ekle(Request $request)
    {
        $request->validate([
            'etkinlik_id' => 'required|exists:etkinlik_yönetimis,id',
            'adet' => 'required|integer|min:1'
        ]);

        $etkinlikId = $request->etkinlik_id;
        $adet = $request->adet;

        $etkinlik = EtkinlikYönetimi::findOrFail($etkinlikId);

        // Adet kontenjanı aşmasın
        if ($adet > $etkinlik->kontenjan) {
            return redirect()->back()->with('error', 'Seçilen bilet adedi, kontenjanı aşamaz.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$etkinlikId])) {
            $yeniAdet = $cart[$etkinlikId]['adet'] + $adet;

            if ($yeniAdet > $etkinlik->kontenjan) {
                return redirect()->back()->with('error', 'Toplam bilet sayısı kontenjanı aşıyor.');
            }

            $cart[$etkinlikId]['adet'] = $yeniAdet;
        } else {
            $cart[$etkinlikId] = [
                'baslik' => $etkinlik->baslik,
                'fiyat' => $etkinlik->bilet_fiyati,
                'adet' => $adet
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Etkinlik sepete başarıyla eklendi.');
    }

    // Sepetten ürün sil
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Etkinlik sepetten kaldırıldı.');
    }

    // Sepeti tamamen boşalt
    public function clear()
    {
        Session::forget('cart');

        return redirect()->route('cart.index')->with('success', 'Sepet başarıyla temizlendi.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $selectedIds = $request->input('selected', []);
        $odemeYontemi = $request->input('odeme_yontemi');

        if (empty($selectedIds)) {
            return response()->json(['success' => false, 'message' => 'Lütfen ödeme için ürün seçiniz.']);
        }

        $toplam = 0;

        foreach ($selectedIds as $id) {
            if (!isset($cart[$id])) continue;

            $item = $cart[$id];
            $adet = (int) $item['adet'];
            $fiyat = (float) $item['fiyat'];
            $toplam += $adet * $fiyat;

            // Etkinliği al ve kontenjan kontrolü yap
            $etkinlik = \App\Models\EtkinlikYönetimi::find($id);
            if ($etkinlik && $etkinlik->kontenjan >= $adet) {
                $etkinlik->kontenjan -= $adet;
                $etkinlik->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Yetersiz kontenjan: ' . ($etkinlik->baslik ?? 'Etkinlik bulunamadı')
                ]);
            }

            // Sepetten ürünü çıkar
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }


}
