<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    use HasFactory;
    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'is_active',
    ];
}
