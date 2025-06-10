<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $categories = Category::where('is_active', true)->get();
            $colors = Attribute::distinct()->pluck('color')->filter()->toArray();
            $sizes = Attribute::distinct()->pluck('size')->filter()->toArray();

            $query = Product::with(['category', 'attributes']);

            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('color')) {
                $query->whereHas('attributes', function ($q) use ($request) {
                    $q->where('color', $request->color);
                });
            }

            if ($request->filled('size')) {
                $query->whereHas('attributes', function ($q) use ($request) {
                    $q->where('size', $request->size);
                });
            }

            if ($request->filled('sort') && $request->sort === 'latest') {
                $query->latest();
            }

            $products = $query->get();
            $popularProducts = Product::with(['category', 'attributes'])->take(4)->get();

            return view('client.home.index', compact('categories', 'products', 'popularProducts', 'colors', 'sizes'));
        } catch (\Exception $e) {
            \Log::error('HomeController::index error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Виникла помилка при завантаженні сторінки.');
        }
    }

    public function filter(Request $request)
    {
        try {
            $query = Product::with(['category', 'attributes']);

            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('color')) {
                $query->whereHas('attributes', function ($q) use ($request) {
                    $q->where('color', $request->color);
                });
            }

            if ($request->filled('size')) {
                $query->whereHas('attributes', function ($q) use ($request) {
                    $q->where('size', $request->size);
                });
            }

            if ($request->filled('sort') && $request->sort === 'latest') {
                $query->latest();
            }

            $products = $query->get();

            return response()->json(
                $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => number_format($product->price, 2),
                        'image_path' => $product->image_path ? asset($product->image_path) : null,
                        'category_name' => $product->category->name ?? '—',
                        'attributes' => $product->attributes->map(function ($attr) {
                            return ['color' => $attr->color ?? 'N/A', 'size' => $attr->size ?? 'N/A'];
                        }),
                    ];
                })
            );
        } catch (\Exception $e) {
            \Log::error('HomeController::filter error: ' . $e->getMessage());
            return response()->json(['error' => 'Виникла помилка при фільтрації.'], 500);
        }
    }
}
