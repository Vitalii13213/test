<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $query = Product::where('is_active', true)->with(['colors', 'sizes']);

        if ($request->has('filter')) {
            if ($request->has('color')) {
                $query->whereHas('colors', function ($q) use ($request) {
                    $q->where('id', $request->color);
                });
            }
            if ($request->has('size')) {
                $query->whereHas('sizes', function ($q) use ($request) {
                    $q->where('id', $request->size);
                });
            }
        }

        $products = $query->paginate(12);

        return view('client.products.index', compact('products', 'categories'));
    }

    public function showCategory($id)
    {
        $category = Category::with(['products' => function ($query) {
            $query->where('is_active', true);
        }])->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.categories.show', compact('category', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['colors', 'sizes'])->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.products.show', compact('product', 'categories'));
    }

    public function customize($id)
    {
        $product = Product::with(['colors', 'sizes'])->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.products.customize', compact('product', 'categories'));
    }

    public function storeCustomize(Request $request, $id)
    {
        $request->validate([
            'design' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $path = $request->file('design')->store('custom_designs', 'public');

        \App\Models\CustomDesign::create([
            'product_id' => $id,
            'image_path' => $path,
        ]);

        return redirect()->route('products.show', $id)->with('success', 'Кастомізація збережена');
    }
}
