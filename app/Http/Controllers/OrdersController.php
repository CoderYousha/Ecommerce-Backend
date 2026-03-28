<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdersRequests\CreateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    //Create Order Function
    public function store (CreateOrderRequest $createOrderRequest){
        return $this->orderService->createOrder($createOrderRequest->all());
    }

    //Cancel Order Function
    public function cancel (Order $order){
        return $this->orderService->cancelOrder($order);
    }

    //Get Orders Function
    public function read (Request $request){
        return $this->orderService->getOrders($request->per_page, $request->user_id);
    }

    //Get Order Function
    public function show (Order $order){
        return $this->orderService->getOrder($order);
    }
}
