<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','description','base_price','category_id'];




    function categories(){
        return $this->belongsto(Category::class);
    }
     function wishlist(){
        return $this->belongsTo(Wishlist::class);
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
