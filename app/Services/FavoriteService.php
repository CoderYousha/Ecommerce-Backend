<?php

namespace App\Services;

use App\Models\FavoriteProduct;
use App\Models\Product;
use App\Transformers\Products\ProductResponse;
use App\Transformers\Products\ProductsResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteService {
    public function favorite(Product $product){
        $user = Auth::guard('user')->user();
        $favorite = FavoriteProduct::where('product_id', $product->id)->where('user_id', $user->id)->first();
        
        if($favorite){
            $favorite->delete();

            return success(null, 'Product removed from favorite');
        }

        FavoriteProduct::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        return success(ProductResponse::format($product), 'Product added to favorite', 201);
    }

    public function getFavorite($perPage){
        $user = Auth::guard('user')->user();
        $favorites = $user->favoriteProducts()->paginate($perPage ?? 10);

        return success(ProductsResponse::format($favorites), 'Favorite information');
    }
}