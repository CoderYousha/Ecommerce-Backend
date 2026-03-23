<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table ='orders';
    protected $fillable = [
        'user_id',
        'location_id',
        'status',
        'payment_method',
        'payment_status',
    ];
}
