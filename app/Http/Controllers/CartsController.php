<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartsRequests\CreateCartRequest;
use App\Http\Requests\CartsRequests\UpdateCartRequest;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    //Create Cart Function
    public function store (CreateCartRequest $createCartRequest) {
        return $this->cartService->createCart($createCartRequest->all());
    }

    //Update Cart Function
    public function update (Cart $cart, UpdateCartRequest $updateCartRequest){
        return $this->cartService->updateCart($cart, $updateCartRequest->amount);
    }

    //Delete Cart Function
    public function delete(Cart $cart){
        return $this->cartService->deleteCart($cart);
    }

    //Get Carts Function
    public function read () {
        return $this->cartService->getCarts();
    }
}
