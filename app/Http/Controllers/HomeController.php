<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)->with(['colors', 'sizes'])->take(10)->get();
        $title = 'StyleHub - Головна';
        return view('layouts.main', compact('categories', 'products', 'title'));
    }

    public function filter(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)->with(['colors', 'sizes']);

        if ($request->category_id) {
            $products->where('category_id', $request->category_id);
        }

        if ($request->min_price) {
            $products->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $products->where('price', '<=', $request->max_price);
        }

        if ($request->color_id) {
            $products->whereHas('colors', function ($query) use ($request) {
                $query->where('color_id', $request->color_id);
            });
        }

        if ($request->size_id) {
            $products->whereHas('sizes', function ($query) use ($request) {
                $query->where('size_id', $request->size_id);
            });
        }

        $products = $products->get();
        return view('products.index', compact('products', 'categories'));
    }
}
