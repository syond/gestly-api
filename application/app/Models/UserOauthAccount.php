<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserOauthAccount extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
