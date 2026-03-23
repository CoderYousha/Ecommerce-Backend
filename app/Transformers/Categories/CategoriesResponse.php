<?php

namespace App\Transformers\Categories;

use App\Transformers\Pagination\PaginationResponse;

class CategoriesResponse
{
    public static function format($categories)
    {
        $data = ['categories' => []];

        foreach ($categories as $category) {
            $data['categories'][] = [
                'id' => $category->id,
                'name_en' => $category->name_en,
                'name_ar' => $category->name_ar,
                'status' => $category->status,
            ];
        }

        $data['pagination'] = PaginationResponse::format($categories);

        return $data;
    }
}
