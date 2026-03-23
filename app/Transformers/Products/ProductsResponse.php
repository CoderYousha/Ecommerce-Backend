<?php

namespace App\Transformers\Products;

use App\Transformers\Categories\CategoryResponse;
use App\Transformers\Pagination\PaginationResponse;

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
                CategoryResponse::format($product->category),
            ];
        }

        $data['pagination'] = PaginationResponse::format($products);

        return $data;
    }
}
