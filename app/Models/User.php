<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'whatsapp_phone',
        'password',
        'role',
        'status',
    ];

    public function favoriteProducts (){
        return $this->belongsToMany(Product::class, 'favorite_products', 'user_id', 'product_id');
    }

    public function carts() {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }
}
