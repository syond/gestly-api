<?php

namespace App\Models;

use App\Models\Model;

class MediaPost extends Model
{
    protected $fillable = [
        'id',
        'media_object_id',
        'post_id',
    ];

    public function mediaObject()
    {
        return $this->belongsTo(MediaObject::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
