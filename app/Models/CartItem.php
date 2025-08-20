<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {
    use HasFactory;
    protected $fillable = ['cart_id', 'product_variation_id', 'quantity', 'price', 'sub_total'];

    public function cart() {
        return $this->belongsTo(Cart::class);
    }
    public function productVariation() {
        return $this->belongsTo(ProductVariation::class);
    }
}
