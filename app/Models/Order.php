<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'customer', 'phone', 'shipment_description',
        'declared_value', 'weight', 'length', 'height', 'width',
        'city', 'delivery_point', 'total', 'status', 'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price', 'color_id', 'size_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
