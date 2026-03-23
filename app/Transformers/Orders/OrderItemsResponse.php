<?php

use App\Transformers\Products\ProductResponse;

class OrderItemsResponse {
    public static function format ($items) {
        $data = ['items' => []];

        foreach ($items as $item){
            $data['items'][] = [
                'id' => $item->id,
                'amount' => $item->amount,
                'total_price' => $item->total_price,
                ProductResponse::format($item->product),
            ];
        }
    }
}