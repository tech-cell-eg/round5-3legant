<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id','product_variation_id','quantity','price'];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}

