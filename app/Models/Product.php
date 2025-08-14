<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','description','base_price','category_id'];

    public function collections()
      {
          return $this->belongsToMany(Collection::class);
      }
}
