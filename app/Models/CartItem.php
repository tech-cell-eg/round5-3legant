<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {
    protected $fillable = ['cart_id', 'product_variation_id', 'quantity', 'price'];
}
