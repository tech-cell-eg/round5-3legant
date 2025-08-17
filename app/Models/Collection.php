<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['name', 'image', 'is_featured'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

