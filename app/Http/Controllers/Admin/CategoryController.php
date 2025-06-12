<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Виправлене: коректно обробляємо show_inactive як булевий параметр
        $showInactive = $request->boolean('show_inactive', false);

        $query = Category::query();

        if (!$showInactive) {
            $query->where('is_active', true);
        }

        $categories = $query->get();

        return view('admin.categories.index', compact('categories', 'showInactive'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Категорію додано.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $category = Category::findOrFail($id);
        $oldIsActive = $category->is_active;
        $category->update($request->all());

        // Якщо категорія стала неактивною — деактивуємо її продукти
        if ($oldIsActive && !$request->is_active) {
            Product::where('category_id', $id)->update(['is_active' => false]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Категорію оновлено.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категорію видалено.');
    }
}
