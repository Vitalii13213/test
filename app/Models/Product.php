<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'stock', 'image', 'description', 'category_id', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'size_product');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price', 'color_id', 'size_id');
    }

    public function storeCustomize(Request $request, $id)
    {
        // Логіка для кастомізації
        return redirect()->route('products.show', $id)->with('success', 'Кастомізація збережено.');
    }
}
