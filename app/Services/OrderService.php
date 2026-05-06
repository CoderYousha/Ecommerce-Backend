<?php

namespace App\Services;

use App\Models\ClientNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Transformers\Orders\OrderResponse;
use App\Transformers\Orders\OrdersResponse;
use Illuminate\Support\Facades\Auth;
use OrderItemsResponse;

class OrderService
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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
        $url = $host . ':' . $port;
        $stateEn = $status == 'accepted' ? 'Accepted' : ($status == 'in_preparation' ? 'In Preparation' : ($status == 'to_deliver' ? 'To Deliver' : ($status == 'delivered' ? 'Delivered' : 'Canceled')));
        $stateAr = $status == 'accepted' ? 'تمت الموافقة' : ($status == 'in_preparation' ? 'قيد التجهيز' : ($status == 'to_deliver' ? 'قيد التوصيل' : ($status == 'delivered' ? 'تم التوصيل' : 'تم الإلغاء')));
        $user = User::find($order->user_id);

        $order->update([
            'status' => $status,
            'payment_status' => $paymentStatus,
        ]);

        $notification = ClientNotification::create([
            'user_id' => $order->user_id,
            'name_en' => 'Order Status',
            'name_ar' => 'حالة الطلب',
            'description_en' => "Order ID {$order->id} status become $stateEn",
            'description_ar' => "الطلب صاحب الرقم {order->id} أصبحت حالته $stateAr",
            'type' => 'Order',
            'link' => 'http://localhost:3000/orders/' . $order->id,
        ]);

        if ($user->language == 'en')
            $this->notificationService->sendNotification($user->fcm_token, "New Product Added", $notification->description_en, $product->images[0]->image, '/orders');
        else
            $this->notificationService->sendNotification($user->fcm_token, "تمت إضافة منتج جديد", $notification->description_ar, $product->images[0]->image, '/orders');

        return success(OrderResponse::format($order), 'Order Status changed successfully');
    }



    public function getOrders($perPage, $user_id, $search)
    {
        if ($user_id) {
            $orders = Order::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate($perPage ?? 10);
        } else {
            $orders = Order::where('id', 'LIKE', "%{$search}%")->orderBy('created_at', 'desc')->paginate($perPage ?? 10);
        }

        return success(OrdersResponse::format($orders), 'Orders Information');
    }

    public function getOrder(Order $order)
    {
        return success(OrderResponse::format($order), 'Order Information');
    }
}
