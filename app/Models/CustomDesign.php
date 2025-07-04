<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomDesign extends Model
{
    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
