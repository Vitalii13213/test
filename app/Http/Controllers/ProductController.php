<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CustomDesign;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('category', 'attributes')->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.products.show', compact('product', 'categories'));
    }

    public function customize($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.products.customize', compact('product', 'categories'));
    }

    public function storeCustomize(Request $request, $id)
    {
        $request->validate([
            'design' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $path = $request->file('design')->store('custom_designs', 'public');

        CustomDesign::create([
            'product_id' => $id,
            'image_path' => $path,
        ]);

        return redirect()->route('cart.index')->with('success', 'Кастомний дизайн додано до кошика.');
    }
}
