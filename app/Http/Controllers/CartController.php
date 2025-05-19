<?php

namespace App\Http\Controllers;

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

    // Sepete ürün ekle
    public function add(Request $request)
    {
        $product = $request->only('id', 'name', 'price');
        $product['quantity'] = 1;

        $cart = Session::get('cart', []);

        // Eğer ürün zaten sepette varsa adedini artır
        if (isset($cart[$product['id']])) {
            $cart[$product['id']]['quantity'] += 1;
        } else {
            $cart[$product['id']] = $product;
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Ürün sepete eklendi.');
    }

    // Sepetten ürün sil
    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Ürün sepetten silindi.');
    }

    // Sepeti tamamen boşalt
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Sepet boşaltıldı.');
    }
}


