<?php

namespace App\Transformers\Pagination;

class PaginationResponse {
    public static function format ($data){
        $data = [
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
        ];

        return $data;
    }
}