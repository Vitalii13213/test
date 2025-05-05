<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Session::get('categories', [
            ['id' => 1, 'name' => 'T-Shirts', 'description' => 'Casual and trendy t-shirts'],
            ['id' => 2, 'name' => 'Jeans', 'description' => 'Comfortable denim jeans'],
            ['id' => 3, 'name' => 'Dresses', 'description' => 'Elegant and stylish dresses'],
        ]);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $categories = Session::get('categories', []);
        $newId = count($categories) ? max(array_column($categories, 'id')) + 1 : 1;

        $categories[] = [
            'id' => $newId,
            'name' => $request->name,
            'description' => $request->description,
        ];

        Session::put('categories', $categories);

        return redirect()->route('admin.categories')->with('success', 'Category added successfully.');
    }

    public function edit($id)
    {
        $categories = Session::get('categories', []);
        $category = collect($categories)->firstWhere('id', $id);

        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'Category not found.');
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $categories = Session::get('categories', []);
        $categoryIndex = collect($categories)->search(fn($item) => $item['id'] == $id);

        if ($categoryIndex === false) {
            return redirect()->route('admin.categories')->with('error', 'Category not found.');
        }

        $categories[$categoryIndex] = [
            'id' => $id,
            'name' => $request->name,
            'description' => $request->description,
        ];

        Session::put('categories', $categories);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $categories = Session::get('categories', []);
        $categoryIndex = collect($categories)->search(fn($item) => $item['id'] == $id);

        if ($categoryIndex === false) {
            return redirect()->route('admin.categories')->with('error', 'Category not found.');
        }

        unset($categories[$categoryIndex]);
        Session::put('categories', array_values($categories));

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
