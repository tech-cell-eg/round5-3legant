<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model {
    protected $fillable = ['user_id', 'address_id', 'final_price', 'status' , 'first_name', 'last_name', 'phone', 'email',
        'address', 'country', 'city', 'state', 'zip_code',
        'payment_method', 'subtotal', 'discount', 'total', 'status'];

class Order extends Model
{
    protected $fillable = ['user_id','address_id','final_price','status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    function address() {
        return $this->belongsTo(Address::class);
    }
    function order_items() {
        return $this->hasMany(OrderItem::class);
    }
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }


        public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


}
