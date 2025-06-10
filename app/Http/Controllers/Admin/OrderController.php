<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('date', 'desc')->paginate(10);
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.orders.index', compact('orders', 'categories'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Замовлення видалено.');
    }
}
