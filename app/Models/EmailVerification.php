<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'name',
        'username',
        'password_hash',
        'attempts',
        'is_admin_verification',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_admin_verification' => 'boolean',
    ];

    public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function isMaxAttempts()
    {
        return $this->attempts >= 5;
    }
}
