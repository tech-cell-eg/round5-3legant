<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {
    protected $fillable = ['product_variation_id', 'image'];
    public function product_varitaion() {
        return $this->belongsTo(Product::class);
    }
}
