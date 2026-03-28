<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Transformers\Orders\OrderResponse;
use App\Transformers\Orders\OrdersResponse;
use Illuminate\Support\Facades\Auth;
use OrderItemsResponse;

class OrderService
{
    public function createOrder($data)
    {
        $user = Auth::guard('user')->user();
        $carts = $user->carts;
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';
        $data['payment_status'] = 'pending';

        $order = Order::create($data);

        foreach ($carts as $cart) {
            if ($cart->amount > $cart->product->amount) {
                return error('some thing went wrong', 'No enoght products');
            }
        }

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product->id,
                'amount' => $cart->amount,
                'total_price' => $cart->product->price * $cart->amount,
            ]);
            $cart->product->update([
                'amount' => $cart->product->amount - $cart->amount
            ]);
            $cart->delete();
        }

        return success(OrderResponse::format($order), 'Order created successfully', 201);
    }

    public function cancelOrder(Order $order)
    {
        if ($order->status == 'pending')
            foreach ($order->items as $item) {
                $item->product->update([
                    'amount' => $item->amount + $item->product->amount,
                ]);
            }

        $order->update([
            'status' => 'canceled'
        ]);

        return success(OrderResponse::format($order), 'Order canceled successfully');
    }

    public function getOrders($perPage, $user_id)
    {
        if ($user_id) {
            $orders = Order::where('user_id', $user_id)->paginate($perPage ?? 10);
        } else {
            $orders = Order::paginate($perPage ?? 10);
        }

        return success(OrdersResponse::format($orders), 'Orders Information');
    }

    public function getOrder(Order $order)
    {
        return success(OrderResponse::format($order), 'Order Information');
    }
}
