<?php

namespace App\Transformers\Orders;

use App\Transformers\Locations\LocationResponse;
use App\Transformers\Users\UserResponse;

class OrderResponse {
    public static function format ($order) {
        $data = [
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                'user' => UserResponse::format($order->user)['user'],
                'location' => LocationResponse::format($order->location)['location'],
                'items' => OrderItemsResponse::format($order->items)['items'],
            ]
        ];

        return $data;
    }
}