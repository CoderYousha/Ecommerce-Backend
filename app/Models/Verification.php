<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Verification extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'verifications';
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'whatsapp_phone',
        'password',
        'role',
        'code',
        'expiry_date',
    ];
}
