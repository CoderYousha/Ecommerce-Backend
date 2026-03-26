<?php

namespace App\Transformers\Carts;

use App\Transformers\Products\ProductResponse;

class CartResponse
{
    public static function format($cart)
    {
        $data = [
            'cart' => [
                'id' => $cart->id,
                'amount' => $cart->amount,
                'product' => ProductResponse::format($cart->product)['product'],
            ]
        ];
        return $data;
    }
}
