<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = ['items', 'user'];
    protected $table ='orders';
    protected $fillable = [
        'user_id',
        'location_id',
        'status',
        'payment_method',
        'payment_status',
    ];

    public function user (){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function items (){
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
