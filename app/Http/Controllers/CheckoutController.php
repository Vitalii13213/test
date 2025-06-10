<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        return view('client.checkout.index', compact('categories', 'cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'full_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'delivery_point' => 'required|string|max:255',
            'shipment_description' => 'nullable|string|max:255',
            'declared_value' => 'required|numeric',
            'weight' => 'required|numeric',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Кошик порожній.');
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $order = Order::create([
            'user_id' => Auth::id(),
            'customer' => $request->full_name,
            'phone' => $request->phone,
            'shipment_description' => $request->shipment_description ?? 'Одяг',
            'declared_value' => $request->declared_value,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'city' => $request->city,
            'delivery_point' => $request->delivery_point,
            'total' => $total,
            'status' => 'pending',
            'date' => now(),
        ]);

        foreach ($cart as $id => $item) {
            $order->products()->attach($id, [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Замовлення оформлено.');
    }
}
