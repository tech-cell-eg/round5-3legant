<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','address_id','final_price','status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
