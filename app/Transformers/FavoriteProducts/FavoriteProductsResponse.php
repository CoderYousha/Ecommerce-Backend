<?php

namespace App\Transformers\FavoriteProducts;

use App\Transformers\Products\ProductResponse;

class FavoriteProductsResponse {
    public static function format ($favorites) {
        $data = ['products' => []];

        foreach ($favorites as $favorite){
            $data['products'][] = [
                'id' => $favorite->id,
                ProductResponse::format($favorite->product),
            ];
        }
    }
}