<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('client.cart.index', compact('cart', 'categories'));
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with(['colors', 'sizes'])->findOrFail($id);
        $size = Size::findOrFail($request->size_id);
        $color = $request->color_id ? Color::find($request->color_id) : null;

        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Недостатньо товару на складі.');
        }

        $cart = session('cart', []);
        $cartKey = $id . '_' . $request->size_id . '_' . ($request->color_id ?? 'no_color');

        $cart[$cartKey] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => ($cart[$cartKey]['quantity'] ?? 0) + $request->quantity,
            'size_id' => $size->id,
            'size_name' => $size->name,
            'color_id' => $color ? $color->id : null,
            'color_name' => $color ? $color->name : 'Без кольору',
            'color_hex' => $color ? $color->hex : '#FFFFFF',
        ];

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Товар додано до кошика.');
    }

    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        if (isset($cart[$cartKey])) {
            $product = Product::findOrFail($cart[$cartKey]['product_id']);
            if ($request->quantity > $product->stock) {
                return redirect()->back()->with('error', 'Недостатньо товару на складі.');
            }
            $cart[$cartKey]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index')->with('success', 'Кількість оновлено.');
    }

    public function remove($cartKey)
    {
        $cart = session('cart', []);
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
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
