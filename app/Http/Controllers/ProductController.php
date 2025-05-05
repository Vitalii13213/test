<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        $products = Session::get('products', [
            ['id' => 1, 'name' => 'Blue T-Shirt', 'category' => 'T-Shirts', 'price' => 19.99, 'stock' => 50],
            ['id' => 2, 'name' => 'Black Jeans', 'category' => 'Jeans', 'price' => 49.99, 'stock' => 30],
            ['id' => 3, 'name' => 'Red Dress', 'category' => 'Dresses', 'price' => 79.99, 'stock' => 20],
        ]);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Session::get('categories', [
            ['id' => 1, 'name' => 'T-Shirts', 'description' => 'Casual and trendy t-shirts'],
            ['id' => 2, 'name' => 'Jeans', 'description' => 'Comfortable denim jeans'],
            ['id' => 3, 'name' => 'Dresses', 'description' => 'Elegant and stylish dresses'],
        ]);

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $products = Session::get('products', []);
        $newId = count($products) ? max(array_column($products, 'id')) + 1 : 1;

        $products[] = [
            'id' => $newId,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        Session::put('products', $products);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $products = Session::get('products', []);
        $categories = Session::get('categories', [
            ['id' => 1, 'name' => 'T-Shirts', 'description' => 'Casual and trendy t-shirts'],
            ['id' => 2, 'name' => 'Jeans', 'description' => 'Comfortable denim jeans'],
            ['id' => 3, 'name' => 'Dresses', 'description' => 'Elegant and stylish dresses'],
        ]);

        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $products = Session::get('products', []);
        $productIndex = collect($products)->search(fn($item) => $item['id'] == $id);

        if ($productIndex === false) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        $products[$productIndex] = [
            'id' => $id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        Session::put('products', $products);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $products = Session::get('products', []);
        $productIndex = collect($products)->search(fn($item) => $item['id'] == $id);

        if ($productIndex === false) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        unset($products[$productIndex]);
        Session::put('products', array_values($products));

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }
}
