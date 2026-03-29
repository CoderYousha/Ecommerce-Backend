<?php

namespace App\Services;

use App\Models\ClientNotification;
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

    public function changeOrderStatus(Order $order, $status, $paymentStatus)
    {
        $host = request()->getHost();
        $port = request()->getPort();
        $url = $host + ':' + $port + '/';
        $stateEn = $status == 'accepted' ? 'Accepted' : ($status == 'in_preparation' ? 'In Preparation' : ($status == 'to_deliver' ? 'To Deliver' : ($status == 'delivered' ? 'Delivered' : 'Canceled')));
        $stateAr = $status == 'accepted' ? 'تمت الموافقة' : ($status == 'in_preparation' ? 'قيد التجهيز' : ($status == 'to_deliver' ? 'قيد التوصيل' : ($status == 'delivered' ? 'تم التوصيل' : 'تم الإلغاء')));

        $order->update([
            'status' => $status,
            'payment_status' => $paymentStatus,
        ]);

        ClientNotification::create([
            'user_id' => $order->user_id,
            'name_en' => 'Order Status',
            'name_ar' => 'حالة الطلب',
            'description_en' => `Order ID {$order->id} status become $stateEn`,
            'description_ar' => `الطلب صاحب الرقم {order->id} أصبحت حالته $stateAr`,
            'type' => 'Order',
            'link' => $url . '/api/orders/' . $order->id,
        ]);

        return success(OrderResponse::format($order), 'Order Status changed successfully');
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
