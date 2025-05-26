<?php

// Bu dosya, kullanıcı sepeti işlemlerini yöneten kontrolcüyü tanımlar.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Bu sınıf, sepete ürün ekleme, sepeti görüntüleme, ödeme ve sepetten ürün silme gibi işlevleri sağlar.

    public function add(Request $request)
    {
        // Sepete ürün ekleme metodu.
        if (!auth()->check()) {
            // Kullanıcı giriş yapmamışsa yönlendir.
            return redirect()->route('login')->with('error', 'Sepete eklemek için giriş yapmalısınız.');
        }

        $user = auth()->user();
        $bilets = $request->input('bilets', []);
        // İstekten bilet ID'lerini ve miktarlarını alır.

        foreach ($bilets as $ticketId => $quantity) {
            // Her bir bilet için döngü.
            $quantity = intval($quantity);
            if ($quantity > 0) {
                $ticket = TicketType::find($ticketId);
                if (!$ticket) continue; // Bilet bulunamazsa atla.

                $existing = CartItem::where('user_id', $user->id)->where('ticket_type_id', $ticketId)->first();
                $existingQty = $existing ? $existing->quantity : 0;
                // Sepetteki mevcut miktarı kontrol eder.

                if ($ticket->kontenjan < ($existingQty + $quantity)) {
                    // Kontenjan yeterli değilse hata döndür.
                    return back()->with('error', 'Yeterli kontenjan yok!');
                }

                if ($existing) {
                    // Ürün sepette varsa miktarını artır.
                    $existing->quantity += $quantity;
                    $existing->save();
                } else {
                    // Ürün sepette yoksa yeni kayıt oluştur.
                    CartItem::create([
                        'user_id' => $user->id,
                        'ticket_type_id' => $ticketId,
                        'quantity' => $quantity,
                    ]);
                }
            }
        }

        return back()->with('success', 'Sepete başarıyla eklendi!');
        // Başarı mesajıyla geri yönlendir.
    }

    public function index()
    {
        // Sepet içeriğini görüntüleme metodu.
        $cartItems = CartItem::with('ticketType')
            ->where('user_id', auth()->id())
            ->get();
        // Kullanıcının sepetindeki ürünleri ilgili bilet türleriyle birlikte çeker.

        return view('cart.index', compact('cartItems'));
        // 'cart.index' görünümünü sepet öğeleriyle birlikte döndürür.
    }

    public function checkout(Request $request)
    {
        // Ödeme işlemini gerçekleştiren metot.
        if (!auth()->check()) {
            // Kullanıcı giriş yapmamışsa yönlendir.
            return redirect()->route('login')->with('error', 'Ödeme yapmak için giriş yapmalısınız.');
        }

        $method = $request->input('payment_method');
        $validMethods = ['card', 'havale', 'eft'];
        // Geçerli ödeme yöntemlerini tanımlar.

        if (!in_array($method, $validMethods)) {
            // Geçersiz ödeme yöntemi kontrolü.
            return redirect()->route('anasayfa')->with('success', 'Ödeme işlemi başarıyla tamamlanmıştır.');
        }

        if ($method === 'eft') {
            $method = 'havale'; // EFT'yi havaleye dönüştürür.
        }

        $selectedItems = $request->input('selected_items', []);
        // Seçilen sepet öğelerinin ID'lerini alır.

        if (empty($selectedItems)) {
            // Hiç ürün seçilmemişse hata döndür.
            return back()->with('error', 'Lütfen en az bir ürün seçin.');
        }

        try {
            DB::beginTransaction(); // Veritabanı işlemlerini başlatır.

            $cartItems = CartItem::where('user_id', auth()->id())
                ->whereIn('id', $selectedItems)
                ->with('ticketType')
                ->get();
            // Seçilen sepet öğelerini çeker.

            if ($cartItems->isEmpty()) {
                // Seçilen ürünler bulunamazsa hata döndür.
                return back()->with('error', 'Seçilen ürünler bulunamadı.');
            }

            // Kontenjan kontrolü ve düşürme
            foreach ($cartItems as $item) {
                $ticketType = $item->ticketType;
                if (!$ticketType) {
                    DB::rollBack(); // Hata durumunda işlemleri geri alır.
                    return back()->with('error', 'Bilet türü bulunamadı.');
                }

                if ($ticketType->kontenjan < $item->quantity) {
                    // Kontenjan yeterli değilse hata döndür.
                    DB::rollBack();
                    return back()->with('error', "{$ticketType->name} için yeterli kontenjan yok.");
                }

                $ticketType->kontenjan -= $item->quantity;
                $ticketType->save();
                // Kontenjanı düşürür ve kaydeder.
            }

            // Sepetten seçilen ürünleri sil
            CartItem::where('user_id', auth()->id())
                ->whereIn('id', $selectedItems)
                ->delete();
            // Seçilen sepet öğelerini siler.

            DB::commit(); // Veritabanı işlemlerini onaylar.

            return redirect()->route('anasayfa')->with('success', 'Ödeme işlemi başarıyla tamamlanmıştır.');
            // Başarı mesajıyla ana sayfaya yönlendirir.
        } catch (\Exception $e) {
            DB::rollBack(); // Hata durumunda işlemleri geri alır.
            return back()->with('error', 'Ödeme sırasında hata oluştu: ' . $e->getMessage());
            // Hata mesajıyla geri yönlendirir.
        }
    }
    public function deleteSelected(Request $request)
    {
        // Seçilen sepet öğelerini silme metodu.
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            // Hiç ürün seçilmemişse JSON hata mesajı döndür.
            return response()->json(['success' => false, 'message' => 'Hiç ürün seçilmedi.']);
        }

        try {
            CartItem::where('user_id', auth()->id())
                ->whereIn('id', $selectedItems)
                ->delete();
            // Seçilen sepet öğelerini siler.

            return response()->json(['success' => true]);
            // Başarı JSON yanıtı döndürür.
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Silme işlemi başarısız.']);
            // Hata JSON yanıtı döndürür.
        }
    }

    public function clear(Request $request)
    {
        // Sepeti temizleme metodu.
        auth()->user()->cartItems()->delete();
        // Kullanıcının tüm sepet öğelerini siler.

        return response()->json(['success' => true]);
        // Başarı JSON yanıtı döndürür.
    }

    public function updateQuantity(Request $request)
    {
        // Sepet öğesi miktarını güncelleyen metot.
        $cartItem = CartItem::find($request->id);

        if (!$cartItem || $cartItem->user_id !== auth()->id()) {
            // Ürün bulunamazsa veya kullanıcıya ait değilse hata döndür.
            return response()->json(['success' => false, 'message' => 'Ürün bulunamadı.']);
        }

        if ($request->action === 'increase') {
            $cartItem->quantity += 1; // Miktarı artırır.
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1; // Miktarı azaltır.
            } else {
                return response()->json(['success' => false, 'message' => 'Adet 1\'den az olamaz.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Geçersiz işlem.']);
        }

        $cartItem->save(); // Değişiklikleri kaydeder.

        return response()->json([
            'success' => true,
            'new_quantity' => $cartItem->quantity
        ]);
        // Yeni miktar ile başarı JSON yanıtı döndürür.
    }
}
