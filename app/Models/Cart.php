<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    protected $fillable = ['user_id', 'sub_total', 'total_price', 'shipping_type', 'shipping_cost'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function items() {
        return $this->hasMany(CartItem::class);
    }
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }
}
