<?php

namespace App\Transformers\Products;

use App\Transformers\Categories\CategoryResponse;

class ProductResponse {
    public static function format ($product) {
        $data = [
            'product' => [
                'id'=> $product->id,
                'name_en' => $product->name_en,
                'name_ar' => $product->name_ar,
                'description_en' => $product->description_en,
                'description_ar' => $product->description_ar,
                'price' => $product->price,
                'amount' => $product->amount,
                'images' => $product->images,
                CategoryResponse::format($product->category),
            ]
        ];

        return $data;
    }
}