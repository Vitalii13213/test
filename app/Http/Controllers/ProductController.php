<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['colors', 'sizes'])->get();
        $categories = Category::where('is_active', true)->get();
        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['colors', 'sizes'])->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.products.show', compact('product', 'categories'));
    }

    public function customize($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('products.customize', compact('product', 'categories'));
    }

    public function storeCustomize(Request $request, $id)
    {
        // Логіка для кастомізації
        return redirect()->route('products.show', $id)->with('success', 'Кастомізація збережено.');
    }
}
