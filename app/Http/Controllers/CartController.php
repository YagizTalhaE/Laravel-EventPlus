<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Sepete eklemek için giriş yapmalısınız.');
        }

        $user = auth()->user();
        $bilets = $request->input('bilets', []);

        foreach ($bilets as $ticketId => $quantity) {
            $quantity = intval($quantity);
            if ($quantity > 0) {
                $ticket = TicketType::find($ticketId);
                if (!$ticket) continue;

                $existing = CartItem::where('user_id', $user->id)->where('ticket_type_id', $ticketId)->first();
                $existingQty = $existing ? $existing->quantity : 0;

                if ($ticket->kontenjan < ($existingQty + $quantity)) {
                    return back()->with('error', 'Yeterli kontenjan yok!');
                }

                if ($existing) {
                    $existing->quantity += $quantity;
                    $existing->save();
                } else {
                    CartItem::create([
                        'user_id' => $user->id,
                        'ticket_type_id' => $ticketId,
                        'quantity' => $quantity,
                    ]);
                }
            }
        }

        return back()->with('success', 'Sepete başarıyla eklendi!');
    }

    public function index()
    {
        $cartItems = CartItem::with('ticketType')
            ->where('user_id', auth()->id())
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Ödeme yapmak için giriş yapmalısınız.');
        }

        $method = $request->input('payment_method');
        $validMethods = ['card', 'havale', 'eft'];

        if (!in_array($method, $validMethods)) {
            return redirect()->route('anasayfa')->with('success', 'Ödeme işlemi başarıyla tamamlanmıştır.');
        }

        if ($method === 'eft') {
            $method = 'havale';
        }

        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return back()->with('error', 'Lütfen en az bir ürün seçin.');
        }

        try {
            DB::beginTransaction();

            // Sepetten seçilen ürünleri kullanıcı bazında al
            $cartItems = CartItem::where('user_id', auth()->id())
                ->whereIn('id', $selectedItems)
                ->with('ticketType') // İlişkili bilet türünü al
                ->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Seçilen ürünler bulunamadı.');
            }

            // Kontenjan kontrolü ve düşürme
            foreach ($cartItems as $item) {
                $ticketType = $item->ticketType;
                if (!$ticketType) {
                    DB::rollBack();
                    return back()->with('error', 'Bilet türü bulunamadı.');
                }

                // Kontenjan yeterli mi?
                if ($ticketType->kontenjan < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "{$ticketType->name} için yeterli kontenjan yok.");
                }

                // Kontenjanı düşür
                $ticketType->kontenjan -= $item->quantity;
                $ticketType->save();
            }

            // Sepetten seçilen ürünleri sil
            CartItem::where('user_id', auth()->id())
                ->whereIn('id', $selectedItems)
                ->delete();

            DB::commit();

            return redirect()->route('anasayfa')->with('success', 'Ödeme işlemi başarıyla tamamlanmıştır.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Hata durumunda kullanıcıyı bilgilendirebilirsin
            return back()->with('error', 'Ödeme sırasında hata oluştu: ' . $e->getMessage());
        }
    }
    public function deleteSelected(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return response()->json(['success' => false, 'message' => 'Hiç ürün seçilmedi.']);
        }

        try {
            CartItem::where('user_id', auth()->id())
                ->whereIn('id', $selectedItems)
                ->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Silme işlemi başarısız.']);
        }
    }

    public function clear(Request $request)
    {
        // Sepeti temizle (kullanıcıya göre)
        auth()->user()->cartItems()->delete();

        return response()->json(['success' => true]);
    }

    public function updateQuantity(Request $request)
    {
        $cartItem = CartItem::find($request->id);

        if (!$cartItem || $cartItem->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Ürün bulunamadı.']);
        }

        if ($request->action === 'increase') {
            $cartItem->quantity += 1;
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
            } else {
                return response()->json(['success' => false, 'message' => 'Adet 1\'den az olamaz.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Geçersiz işlem.']);
        }

        $cartItem->save();

        return response()->json([
            'success' => true,
            'new_quantity' => $cartItem->quantity
        ]);
    }
}
