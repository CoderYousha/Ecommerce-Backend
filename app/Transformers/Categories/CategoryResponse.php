<?php

namespace App\Transformers\Categories;

class CategoryResponse {
    public static function format ($category) {
        $data = [
            'category' => [
                'id' => $category->id,
                'name_en' => $category->name_en,
                'name_ar' => $category->name_ar,
                'status' => $category->status,
            ]
        ];

        return $data;
    }
}