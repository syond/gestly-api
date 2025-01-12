<?php

namespace App\Models;

use App\Models\Model;

class PostInteraction extends Model
{
    const INTERACTION_TYPE_FAVORITE = 0;
    const INTERACTION_TYPE_HIDE = 1;
    const INTERACTION_TYPE_FLAG = 2;
    const INTERACTION_TYPE_RATE = 3;

    protected $fillable = [
        'user_id',
        'post_id',
        'interaction_type',
        'value',
    ];

    function user() {
        return $this->belongsTo(User::class);
    }

    function post() {
        return $this->belongsTo(Post::class);
    }
}
