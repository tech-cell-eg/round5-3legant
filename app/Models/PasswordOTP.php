<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordOtp extends Model {
    protected $fillable = ['is_used', 'email', 'otp', 'expires_at'];
}
