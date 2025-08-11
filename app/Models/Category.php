<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $fillable = ['name', 'parent_id'];

     function products(){
        return $this->hasMany(Product::class);
    }
}

