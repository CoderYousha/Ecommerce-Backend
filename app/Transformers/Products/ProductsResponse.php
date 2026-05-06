<?php

namespace App\Transformers\Products;

use App\Models\FavoriteProduct;
use App\Transformers\Categories\CategoryResponse;
use App\Transformers\Pagination\PaginationResponse;
use Illuminate\Support\Facades\Auth;

class ProductsResponse
{
    public static function format($products)
    {
        $data = ['products' => []];

        foreach ($products as $product){
            $data['products'][] = [
                'id'=> $product->id,
                'name_en' => $product->name_en,
                'name_ar' => $product->name_ar,
                'description_en' => $product->description_en,
                'description_ar' => $product->description_ar,
                'price' => $product->price,
                'amount' => $product->amount,
                'images' => $product->images,
                'is_favorite' => FavoriteProduct::where('user_id', Auth::guard('user')->user()->id)->where('product_id', $product->id)->first() ? 1 : 0,
                'category' => CategoryResponse::format($product->category)['category'],
            ];
        }

        $data['pagination'] = PaginationResponse::format($products);

        return $data;
    }
}
