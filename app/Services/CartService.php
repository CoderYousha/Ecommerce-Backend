<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Transformers\Carts\CartResponse;
use App\Transformers\Carts\CartsResponse;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function createCart($data)
    {
        $user = Auth::guard('user')->user();
        $product = Product::find($data['product_id']);
        $data['user_id'] = $user->id;

        if ($data['amount'] > $product->amount) {
            return error('some thing went wrong', 'No enought products');
        }

        $cart = Cart::create($data);

        return success(CartResponse::format($cart), 'Product added to your cart', 201);
    }

    public function updateCart(Cart $cart, $amount)
    {
        if ($amount > $cart->product->amount) {
            return error('some thing went wrong', 'No enought products');
        }

        $cart->update([
            'amount' => $amount,
        ]);

        return success(CartResponse::format($cart), 'Cart updated successfully');
    }

    public function deleteCart (Cart $cart) {
        $cart->delete();

        return success(null, 'Product removed from your cart');
    }

    public function getCarts () {
        $user = Auth::guard('user')->user();
        $carts = $user->carts;

        return success(CartsResponse::format($carts), 'Carts information');
    }
}
