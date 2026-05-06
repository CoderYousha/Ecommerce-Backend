<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $with = ['user'];
    protected $table ='locations';
    protected $fillable = [
        'user_id',
        'city',
        'street',
        'building',
        'floor',
    ];

    public function user (){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
