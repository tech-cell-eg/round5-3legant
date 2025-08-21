<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model {
    use HasFactory;
    protected $fillable = ['product_id', 'size', 'color', 'measurements', 'quantity', 'price'];
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function images() {
        return $this->hasMany(ProductImage::class);
    }
    //This function will return true if the quantity you want to store is less than the product quantity
    public function checkTheStock($quantity) {
        return ($quantity <= $this->quantity);
    }
}
