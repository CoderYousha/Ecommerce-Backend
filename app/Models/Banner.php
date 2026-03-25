<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $with = ['product', 'category', 'images'];
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

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function category () {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function images (){
        return $this->hasMany(BannerImage::class, 'banner_id', 'id');
    }
}
