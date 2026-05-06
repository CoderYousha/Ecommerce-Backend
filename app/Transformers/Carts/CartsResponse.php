<?php

namespace App\Transformers\Carts;
use App\Transformers\Products\ProductResponse;

class CartsResponse {
    public static function format ($carts) {
        $data = ['carts' => []];

        foreach($carts as $cart){
            $data['carts'][] = [
                'id' => $cart->id,
                'amount' => $cart->amount,
                'product' => ProductResponse::format($cart->product)['product'],
            ];
        }

        return $data;
    }
}