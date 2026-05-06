<?php

namespace App\Transformers\Banners;

use App\Transformers\Categories\CategoryResponse;
use App\Transformers\Products\ProductResponse;

class BannerResponse {
    public static function format ($banner){
        $data = [
            'banner' => [
                'id' => $banner->id,
                'name_en' => $banner->name_en,
                'name_ar' => $banner->name_ar,
                'start_date' => $banner->start_date,
                'end_date' => $banner->end_date,
                'status' => $banner->status,
                'images' => $banner->images,
                'product' => ProductResponse::format($banner->product)['product'],
                'category' => CategoryResponse::format($banner->category)['category'],
            ]
        ];

        return $data;
    }
}