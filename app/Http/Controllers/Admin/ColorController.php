<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.color.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hex' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        Color::create($request->all());

        return redirect()->route('admin.color.index')->with('success', 'Колір додано.');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.color.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hex' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $color = Color::findOrFail($id);
        $color->update($request->all());

        return redirect()->route('admin.color.index')->with('success', 'Колір оновлено.');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('admin.color.index')->with('success', 'Колір видалено.');
    }
}
