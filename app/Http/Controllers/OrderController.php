<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Session::get('orders', [
            [
                'id' => 101,
                'customer' => 'Смит Джон Іванович',
                'phone' => '+380671234567',
                'shipment_description' => 'Одяг',
                'weight' => 1.5,
                'length' => 30,
                'width' => 20,
                'height' => 10,
                'city' => 'Київ',
                'delivery_point' => 'Відділення Нової Пошти №45',
                'total' => 89.98,
                'status' => 'Pending',
                'date' => '2025-05-01'
            ],
            [
                'id' => 102,
                'customer' => 'Доу Джейн Петрівна',
                'phone' => '+380681234567',
                'shipment_description' => 'Одяг',
                'weight' => 2.0,
                'length' => 40,
                'width' => 25,
                'height' => 15,
                'city' => 'Львів',
                'delivery_point' => 'Поштомат №123',
                'total' => 129.97,
                'status' => 'Shipped',
                'date' => '2025-05-02'
            ],
            [
                'id' => 103,
                'customer' => 'Браун Аліса Олегівна',
                'phone' => '+380691234567',
                'shipment_description' => 'Одяг',
                'weight' => 0.8,
                'length' => 25,
                'width' => 15,
                'height' => 8,
                'city' => 'Одеса',
                'delivery_point' => 'Відділення Нової Пошти №12',
                'total' => 49.99,
                'status' => 'Delivered',
                'date' => '2025-05-03'
            ],
        ]);

        return view('orders.index', compact('orders'));
    }

    public function destroy($id)
    {
        $orders = Session::get('orders', []);
        $orderIndex = collect($orders)->search(fn($item) => $item['id'] == $id);

        if ($orderIndex === false) {
            return redirect()->route('admin.orders')->with('error', 'Order not found.');
        }

        unset($orders[$orderIndex]);
        Session::put('orders', array_values($orders));

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
    }
}
