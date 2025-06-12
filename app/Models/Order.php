<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'customer', 'phone_number', 'shipment_description',
        'declared_value', 'weight', 'length', 'height', 'width',
        'city', 'delivery_point', 'total_amount', 'status', 'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price', 'color', 'size')
            ->withTimestamps();
    }
}
