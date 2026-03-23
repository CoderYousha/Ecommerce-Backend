<?php

namespace App\Transformers\Orders;

use App\Transformers\Locations\LocationResponse;
use App\Transformers\Users\UserResponse;
use OrderItemsResponse;

class OrderResponse {
    public static function format ($order) {
        $data = [
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                UserResponse::format($order->user),
                LocationResponse::format($order->location),
                OrderItemsResponse::format($order->items),
            ]
        ];

        return $data;
    }
}