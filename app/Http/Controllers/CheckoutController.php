<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('client.checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'], // Змінили phone на phone_number
            'city' => ['required', 'string', 'max:255'],
            'delivery_point' => ['required', 'string', 'max:255'],
            'delivery_type' => ['required', 'in:warehouse,postomat'],
            'shipment_description' => ['required', 'string', 'max:255'],
            'declared_value' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0.1'],
            'length' => ['required', 'numeric', 'min:1'],
            'width' => ['required', 'numeric', 'min:1'],
            'height' => ['required', 'numeric', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Кошик порожній.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            }),
            'status' => 'pending',
            'surname' => $request->surname,
            'name' => $request->first_name,
            'patronymic' => $request->patronymic,
            'phone_number' => $request->phone_number, // Використовуємо phone_number
            'city' => $request->city,
            'delivery_point' => $request->delivery_point,
            'delivery_type' => $request->delivery_type,
            'shipment_description' => $request->shipment_description,
            'declared_value' => $request->declared_value,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
        ]);

        foreach ($cart as $cartKey => $item) {
            $order->products()->attach($item['product_id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'color_id' => $item['color_id'],
                'size_id' => $item['size_id'],
            ]);
        }

        session()->forget('cart');

        // TODO: Інтеграція з API Нової Пошти для створення відправлення
        return redirect()->route('home')->with('success', 'Замовлення оформлено!');
    }
}
