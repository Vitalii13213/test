<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $showInactive = $request->boolean('show_inactive');
        $categoryId = $request->input('category_id');

        $query = Product::query();

        if (!$showInactive) {
            $query->where('is_active', true)
                ->whereHas('category', function ($q) {
                    $q->where('is_active', true);
                });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories', 'showInactive', 'categoryId'));
    }

    public function create(Request $request): View
    {
        $showInactive = $request->boolean('show_inactive');
        $categories = $showInactive ? Category::all() : Category::where('is_active', true)->get();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.create', compact('categories', 'colors', 'sizes', 'showInactive'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'colors' => ['array', 'exists:colors,id'],
            'sizes' => ['array', 'exists:sizes,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        $imagePath = $request->file('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (!empty($validated['colors'])) {
            $product->colors()->sync($validated['colors']);
        }

        if (!empty($validated['sizes'])) {
            $product->sizes()->sync($validated['sizes']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успішно створено.');
    }

    public function edit(Product $product, Request $request): View
    {
        $showInactive = $request->boolean('show_inactive');
        $categories = $showInactive ? Category::all() : Category::where('is_active', true)->get();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.edit', compact('product', 'categories', 'colors', 'sizes', 'showInactive'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'colors' => ['array', 'exists:colors,id'],
            'sizes' => ['array', 'exists:sizes,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->file('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image' => $validated['image'] ?? $product->image,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $product->colors()->sync($validated['colors'] ?? []);
        $product->sizes()->sync($validated['sizes'] ?? []);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успішно оновлено.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успішно видалено.');
    }
}
