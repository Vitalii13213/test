<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        return view('client.cart.index', compact('products', 'cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Товар додано до кошика');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Товар видалено з кошика');
    }
}
