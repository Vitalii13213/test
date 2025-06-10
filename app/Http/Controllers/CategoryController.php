<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('client.categories.show', compact('category', 'categories'));
    }
}
