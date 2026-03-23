<?php

namespace App\Transformers\Carts;

use App\Transformers\Pagination\PaginationResponse;
use App\Transformers\Products\ProductResponse;

class CartsResponse {
    public static function format ($carts) {
        $data = ['carts' => []];

        foreach($carts as $cart){
            $data['carts'][] = [
                'id' => $cart->id,
                'amount' => $cart->amount,
                ProductResponse::format($cart->product),
            ];
        }

        $data['pagination'] = PaginationResponse::format($carts);

        return $data;
    }
}