<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','address_id','final_price','status'];
    function address(){
        return $this->belongsTo(Address::class);
    }
    function order_items(){
        return $this->hasMany(OrderItem::class);
    }

}
