<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        $cart = session('cart', []);
        return view('client.cart.index', compact('cart', 'categories'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->input('quantity', 1),
                'image' => $product->image,
            ];
        }

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Товар додано до кошика.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index')->with('success', 'Товар видалено з кошика.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Кошик очищено.');
    }
}
