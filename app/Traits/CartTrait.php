<?php

namespace App\Traits;

trait CartTrait
{
    protected function calculateTotal($cart)
    {
        return collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }
}
