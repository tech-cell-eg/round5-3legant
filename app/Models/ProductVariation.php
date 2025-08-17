<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model {
    protected $fillable = ['product_id', 'size', 'color', 'measurements', 'quantity', 'price'];
   
    public function products(){
        $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
