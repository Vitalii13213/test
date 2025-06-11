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
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('client.cart.index', compact('cart', 'total'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $color = Color::findOrFail($request->color_id);
        $size = Size::findOrFail($request->size_id);

        $availableQuantity = $product->stock ?? 1000;
        if ($request->quantity > $availableQuantity) {
            return redirect()->back()->with('error', 'Недостатньо товару в наявності.');
        }

        $cart = session()->get('cart', []);
        $cartKey = $product->id . '_' . $request->color_id . '_' . $request->size_id;

        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;
            if ($newQuantity > $availableQuantity) {
                return redirect()->back()->with('error', 'Недостатньо товару в наявності.');
            }
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'color_id' => $request->color_id,
                'color_name' => $color->name,
                'color_hex' => $color->hex ?? '#ffffff',
                'size_id' => $request->size_id,
                'size_name' => $size->name,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Товар додано до кошика.');
    }

    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return redirect()->route('cart.index')->with('error', 'Товар не знайдено.');
        }

        $productId = $cart[$cartKey]['product_id'];
        $product = Product::findOrFail($productId);
        $availableQuantity = $product->stock ?? 1000;

        if ($request->quantity == 0) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Товар видалено.');
        }

        if ($request->quantity > $availableQuantity) {
            return redirect()->route('cart.index')->with('error', 'Недостатньо товару в наявності.');
        }

        $cart[$cartKey]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Кількість оновлено.');
    }

    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Товар видалено.');
        }

        return redirect()->route('cart.index')->with('error', 'Товар не знайдено.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Кошик очищено.');
    }
}
