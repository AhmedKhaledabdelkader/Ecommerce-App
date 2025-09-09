<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cart_id',
        'user_id',
        'total_price',
        'shipping',
        'status',
    ];
}
