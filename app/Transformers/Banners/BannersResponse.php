<?php

namespace App\Transformers\Banners;

use App\Transformers\Categories\CategoryResponse;
use App\Transformers\Pagination\PaginationResponse;
use App\Transformers\Products\ProductResponse;

class BannersResponse {
    public static function format ($banners){
        $data = ['banners' => []];

        foreach($banners as $banner){
            $data['banners'][] = [
                'id' => $banner->id,
                'name_en' => $banner->name_en,
                'name_ar' => $banner->name_ar,
                'start_date' => $banner->start_date,
                'end_date' => $banner->end_date,
                'status' => $banner->status,
                'images' => $banner->images,
                'product' => ProductResponse::format($banner->product)['product'],
                'category' => CategoryResponse::format($banner->category)['category'],
            ];
        }

        $data['pagination'] = PaginationResponse::format($banners);

        return $data;
    }
}