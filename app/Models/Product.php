<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;
    protected $fillable = ['name', 'description', 'base_price', 'category_id'];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }
    function categories(){
        return $this->belongsto(Category::class);
    }
     function wishlist(){
        return $this->belongsToMany(Wishlist::class);
    }
     function productVariations(){
        return $this->hasMany(ProductVariation::class);
    }
     function reviews(){
        return $this->hasMany(Review::class);
    }
    public function collections()
      {
          return $this->belongsToMany(Collection::class);
      }



}
