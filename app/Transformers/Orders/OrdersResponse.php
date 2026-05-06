<?php

namespace App\Transformers\Orders;

use App\Transformers\Locations\LocationResponse;
use App\Transformers\Pagination\PaginationResponse;
use App\Transformers\Users\UserResponse;

class OrdersResponse {
    public static function format ($orders) {
        $data = ['orders' => []];

        foreach ($orders as $order){
            $data['orders'][] = [
                'id' => $order->id,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'payment_status' => $order->payment_status,
                'user' => UserResponse::format($order->user)['user'],
                'location' => LocationResponse::format($order->location)['location'],
                'items' => OrderItemsResponse::format($order->items)['items'],
            ];
        }

        $data['pagination'] = PaginationResponse::format($orders);

        return $data;
    }
}