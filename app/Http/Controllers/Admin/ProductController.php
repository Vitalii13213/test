<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $showInactive = $request->query('show_inactive', false);
        $categoryId = $request->query('category_id');
        $categories = Category::all();

        $query = Product::with(['category']);
        if (!$showInactive) {
            $query->where('is_active', true);
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->get();
        return view('admin.products.index', compact('products', 'showInactive', 'categories', 'categoryId'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->input('is_active', false);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);
        if ($request->has('colors')) {
            $product->colors()->sync($request->colors);
        }
        if ($request->has('sizes')) {
            $product->sizes()->sync($request->sizes);
        }

        return redirect()->route('admin.products.index')->with('success', 'Товар додано.');
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        $colors = Color::all();
        $sizes = Size::all();
        $showInactive = $request->query('show_inactive', false);
        return view('admin.products.edit', compact('product', 'categories', 'colors', 'sizes', 'showInactive'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();
        $data['is_active'] = $request->input('is_active', false);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        if ($request->has('colors')) {
            $product->colors()->sync($request->colors);
        }
        if ($request->has('sizes')) {
            $product->sizes()->sync($request->sizes);
        }

        return redirect()->route('admin.products.index')->with('success', 'Товар оновлено.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар видалено.');
    }
}
