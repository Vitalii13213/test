<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['product_id', 'color', 'size'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
