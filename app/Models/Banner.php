<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table ='banners';
    protected $fillable = [
        'product_id',
        'category_id',
        'name_en',
        'name_ar',
        'start_date',
        'end_date',
        'status',
    ];
}
