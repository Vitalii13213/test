<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $colors = Color::all();
        $sizes = Size::all();

        $query = Product::where('is_active', true)->with(['colors', 'sizes', 'category'])
            ->whereHas('category', function ($q) {
                $q->where('is_active', true);
            });

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('color_id') && $request->color_id) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('colors.id', $request->color_id);
            });
        }
        if ($request->has('size_id') && $request->size_id) {
            $query->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizes.id', $request->size_id);
            });
        }
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        $sort = $request->input('sort', 'name_asc');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);

        $minPrice = Product::where('is_active', true)->min('price') ?? 0;
        $maxPrice = Product::where('is_active', true)->max('price') ?? 0;

        return view('client.products.index', compact('products', 'categories', 'colors', 'sizes', 'minPrice', 'maxPrice'));
    }

    public function search(Request $request)
    {
        $queryString = $request->input('query');
        $categories = Category::where('is_active', true)->get();
        $colors = Color::all();
        $sizes = Size::all();

        $query = Product::where('is_active', true)->with(['colors', 'sizes', 'category'])
            ->whereHas('category', function ($q) {
                $q->where('is_active', true);
            });

        if ($queryString) {
            $query->where(function ($q) use ($queryString) {
                $q->where('name', 'LIKE', "%{$queryString}%")
                    ->orWhere('description', 'LIKE', "%{$queryString}%");
            });
        }

        $products = $query->paginate(12);

        $minPrice = Product::where('is_active', true)->min('price') ?? 0;
        $maxPrice = Product::where('is_active', true)->max('price') ?? 0;

        return view('client.products.index', compact('products', 'categories', 'colors', 'sizes', 'queryString', 'minPrice', 'maxPrice'));
    }

    public function showCategory($id)
    {
        $category = Category::where('is_active', true)->with(['products' => function ($query) {
            $query->where('is_active', true);
        }])->findOrFail($id);
        $categories = Category::where('is_active', true)->get();

        return view('client.categories.show', compact('category', 'categories'));
    }

    public function show($id)
    {
        $product = Product::where('is_active', true)->with(['colors' => function ($query) {
            $query->select('colors.id', 'colors.name', 'colors.hex');
        }, 'sizes'])->findOrFail($id);
        $categories = Category::where('is_active', true)->get();

        return view('client.products.show', compact('product', 'categories'));
    }

    public function customize($id)
    {
        $product = Product::where('is_active', true)->with(['colors' => function ($query) {
            $query->select('colors.id', 'colors.name', 'colors.hex');
        }, 'sizes'])->findOrFail($id);
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
